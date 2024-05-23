<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Services\Vending\VendingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendingController extends Controller
{
    use ApiResponse;
    public function vend(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'numeric|required|between:1,100000|regex:/^\d+(\.\d{1,2})?$/',
            'phone' => 'required|digits:11',
            'network' => 'required|exists:products,name',
        ],
            [
                'amount.regex' => ':attribute has max of two digits after the decimal point.',
            ]);

        try {
            $product = Product::where('name', $validated['network'])->first();
            $user = auth()->user();
            $wallet = $user->wallet;
            if (bcsub($wallet->balance, $validated['amount'], 3) < 0.0001) {
                return $this->failed([], 'Insufficient user balance', Response::HTTP_FORBIDDEN);
            }
            $transaction = Transaction::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'amount' => $validated['amount'],
            ]);

            $validated['transaction_id'] = $transaction->id;
            $vendingDetails = VendingService::getActiveVendingService()->vend($validated);
            $is_successful = false;
            \DB::transaction(function () use ($validated, $product, $wallet, $transaction, $vendingDetails, &$is_successful) {
                $commission = $product->commission_rate * $validated['amount'];
                $is_successful = $vendingDetails['code'] == 200;
                $transaction->update([
                    'commission' => $commission,
                    'is_successful' => $is_successful,
                    'details' => $vendingDetails['data'],
                ]);
                if ($is_successful) {
                    $wallet->balance -= ($validated['amount'] + $commission);
                    $wallet->save();
                }
            });
            return $is_successful
            ?
            $this->success([
                'transaction' => $transaction], 'Product vended successfully')
            : $this->failed([], $transaction['details']['message'] ?? 'Vending failed. Please try again later.');
        } catch (\Exception $e) {
            \Log::error('Vending failed: ' . $e->getMessage());
            return $this->error([], 'Vending failed. Please try again later.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

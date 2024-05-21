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
            'amount' => 'required',
            'phone' => 'required',
            'network' => 'required|exists:products,name',
        ]);

        try {
            $product = Product::where('name', $validated['network'])->first();
            $user = auth()->user();
            $wallet = $user->wallet;
            if ($wallet->balance < $validated['amount']) {
                return $this->failed([], 'Insufficient balance', Response::HTTP_FORBIDDEN);
            }

            $transaction = Transaction::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'amount' => $validated['amount'],
            ]);

            $validated['transaction_id'] = $transaction->id;
            $vendingDetails = VendingService::getActiveVendingService()->vend($validated);
            // dd($vendingDetails);

            \DB::transaction(function () use ($validated, $product, $wallet, $transaction) {
                $commission = $product->commission_rate * $validated['amount'];
                $transaction->commission = $commission;
                $transaction->save();
                $wallet->balance -= $validated['amount'];
                $wallet->balance += $commission;
                $wallet->save();
            });
            return response()->json([
                'message' => 'Product vended successfully',
                'transaction' => $transaction,
            ]);
        } catch (\Exception $e) {
            \Log::error('Vending failed: ' . $e->getMessage());
            return $this->failed([], 'Vending failed. Please try again later.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

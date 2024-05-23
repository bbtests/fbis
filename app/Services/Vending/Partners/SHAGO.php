<?php

namespace App\Services\Vending\Partners;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class SHAGO implements VendingPartnerInterface
{
    use ApiResponse;

    private $partner, $url;

    public function __construct()
    {
        $this->partner = config('constants.vending_partners')['SHAGO'];
        $this->url = $this->partner['url'];
    }

    public function vend($data)
    {
        $partner = $this->partner;
        $payload = [
            'serviceCode' => $partner['specifics']['service_code'],
            'vend_type' => $partner['specifics']['vend_type'],
            'amount' => $data['amount'],
            'network' => strtolower($data['network']),
            'phone' => $data['phone'],
            'request_id' => config('app.name') . '-' . \Hash::make($data['transaction_id']),
        ];
        $response = Http::withHeaders([
            'hashKey' => $this->partner['api_key'],
            'Accept' => 'application/json',
        ])->timeout(10)->post($this->url, $payload)->json();
        if ($response['status'] == 200) {
            return $this->success($response);
        } else {
            return $this->failed($response, 'Request failed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

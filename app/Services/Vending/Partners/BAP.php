<?php

namespace App\Services\Vending\Partners;

use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class BAP implements VendingPartnerInterface
{
    use ApiResponse;

    private $partner, $url;

    public function __construct()
    {
        $this->partner = config('constants.vending_partners')['BAP'];
        $this->url = $this->partner['url'];
    }

    public function vend($data)
    {
        $partner = $this->partner;
        $payload = [
            'agentId' => $partner['specifics']['agent_id'],
            'plan' => $partner['specifics']['plans'][0],
            'agentReference' => config('app.name') . '-' . \Hash::make($data['transaction_id']),
            'amount' => $data['amount'],
            'phone' => $data['phone'],
            'service_type' => strtoupper($data['network']),
        ];

        $response = Http::withHeaders([
            'x-api-key' => $this->partner['api_key'],
            'Accept' => 'application/json',
        ])->timeout(10)->post($this->url, $payload)->json();
        if ($response['code'] == 200) {
            return $this->success($response);
        } else {
            return $this->failed($response, $response['message'] ?? 'Request failed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}

<?php
use App\Enums\AdminApprovalStatus;
use App\Enums\Currencies;

return [
    'admin_approval' => AdminApprovalStatus::class,
    'currencies' => Currencies::class,
    'vending_partners' => [
        'BAP' => [
            'name' => 'Biller Aggregation Portal',
            'api_key' => env('BAP_API_KEY'),
            'url' => env('BAP_API_URL'),
            'specifics' => [
                'agent_id' => env('BAP_AGENT_ID'),
                'service_type' => 'VTU',
                'service_code' => 'VTU',
                'plans' => [
                    'prepaid',
                ],
            ],
        ],
        'SHAGO' => [
            'name' => 'Shaggo Payments',
            'api_key' => env('SHAGO_API_KEY'),
            'url' => env('SHAGO_API_URL'),
            'specifics' => [
                'vend_type' => 'VTU',
                'service_code' => 'QAB',
            ],
        ],
    ],

];

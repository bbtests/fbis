<?php

namespace App\Services\Vending;

use App\Models\Setting;
use App\Services\Vending\Partners\BAP;
use App\Services\Vending\Partners\SHAGO;

class VendingService
{
    public static function getActiveVendingService()
    {
        $channel = Setting::where('key', 'vending_partner')->first()->value;
        $channelClasses = [
            'BAP' => BAP::class,
            'SHAGO' => SHAGO::class,
        ];

        if (array_key_exists($channel, $channelClasses)) {
            return app($channelClasses[$channel]);
        } else {
            throw new \Exception('No payment gateway selected.');
        }
    }
}

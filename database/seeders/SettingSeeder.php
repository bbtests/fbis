<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'user_verification',
            'value' => false,
            'description' => 'Should user be verified before login?',
        ]);
        Setting::create([
            'key' => 'vending_partner',
            'value' => array_key_first(config('constants.vending_partners')),
        ]);
    }
}

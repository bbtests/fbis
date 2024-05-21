<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@fbis.com',
            'password' => strtolower(config('app.env')) === 'local' ? 'Adewale@123' : "", // Admin should use password recovery
            'user_verified_at' => Carbon::now(),
        ])->assignRole('Admin');
    }
}

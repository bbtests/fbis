<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if ($category = Category::where('name', 'Airtime')->first()) {
            Product::create([
                'name' => 'MTN',
                'category_id' => $category->id,
                'unit_price' => 1.00,
                'commission_rate' => 0.01,
            ]);
            Product::create([
                'name' => 'GLO',
                'category_id' => $category->id,
                'unit_price' => 1.00,
                'commission_rate' => 0.05,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please create products first.');
            return;
        }

        // Sample badge texts
        $badges = [
            'عرض لمدة محدودة',
            'عرض خاص',
            'تخفيض كبير',
            'عرض اليوم',
            'أفضل سعر',
        ];

        // Create deals for products
        $deals = [];
        $sortOrder = 1;
        
        foreach ($products->take(10) as $product) {
            // Random discount between 10% and 50%
            $discountPercent = rand(10, 50);
            $originalPrice = $product->price;
            $dealPrice = $originalPrice - ($originalPrice * $discountPercent / 100);
            
            $deals[] = [
                'product_id' => $product->id,
                'discount_percent' => $discountPercent,
                'original_price' => $originalPrice,
                'deal_price' => round($dealPrice, 2),
                'badge_text' => $badges[array_rand($badges)],
                'is_active' => true,
                'starts_at' => now(),
                'ends_at' => now()->addDays(rand(7, 30)),
                'sort_order' => $sortOrder++,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        
        Deal::insert($deals);
        
        if ($this->command) {
            $this->command->info('Created ' . count($deals) . ' deals successfully!');
        }
    }
}

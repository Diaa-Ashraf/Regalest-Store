<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductDealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing categories or create a default one
        $category = Category::first();
        
        if (!$category) {
            // Create a default category if none exists
            $category = Category::create([
                'image' => null,
                'ar' => ['name' => 'عروض وتخفيضات'],
                'en' => ['name' => 'Deals & Discounts'],
            ]);
        }

        // Sample deal products (using only existing columns)
        $deals = [
            [
                'price' => 299.00,
                'quantity' => 50,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'power-bank-charger-' . Str::random(5),
                'ar' => [
                    'name' => 'شاحن باور بانك من سلسلة سيبدي من دبليو',
                    'description' => 'شاحن محمول بسعة 10000 مللي أمبير مع شحن سريع',
                    'keywords' => ['شاحن', 'باور بانك', 'محمول'],
                ],
                'en' => [
                    'name' => 'Power Bank Charger from W Series',
                    'description' => 'Portable charger 10000mAh with fast charging',
                    'keywords' => ['charger', 'power bank', 'portable'],
                ],
            ],
            [
                'price' => 160.00,
                'quantity' => 100,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'japanese-bath-loofah-' . Str::random(5),
                'ar' => [
                    'name' => 'ليفة استحمام يابانية ناعمة من سالوكيس',
                    'description' => 'ليفة استحمام فاخرة للبشرة الحساسة',
                    'keywords' => ['ليفة', 'استحمام', 'يابانية'],
                ],
                'en' => [
                    'name' => 'Japanese Soft Bath Loofah from Salokis',
                    'description' => 'Premium bath loofah for sensitive skin',
                    'keywords' => ['loofah', 'bath', 'japanese'],
                ],
            ],
            [
                'price' => 319.00,
                'quantity' => 30,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'teflon-frying-pan-' . Str::random(5),
                'ar' => [
                    'name' => 'طقم طاسة قلي تيفلون من تروفال قطعتين',
                    'description' => 'طقم قلايات تيفال عالية الجودة',
                    'keywords' => ['طاسة', 'قلي', 'تيفال'],
                ],
                'en' => [
                    'name' => 'Teflon Frying Pan Set from Trouval 2pcs',
                    'description' => 'High quality Tefal frying pan set',
                    'keywords' => ['pan', 'frying', 'tefal'],
                ],
            ],
            [
                'price' => 325.00,
                'quantity' => 25,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'smart-watch-antra-' . Str::random(5),
                'ar' => [
                    'name' => 'ساعة ذكية أنترا ماكس شاشة 49 ملم',
                    'description' => 'ساعة ذكية بشاشة AMOLED ومقاومة للماء',
                    'keywords' => ['ساعة', 'ذكية', 'أنترا'],
                ],
                'en' => [
                    'name' => 'Antra Max Smart Watch 49mm Screen',
                    'description' => 'Smart watch with AMOLED display and water resistant',
                    'keywords' => ['watch', 'smart', 'antra'],
                ],
            ],
            [
                'price' => 88.00,
                'quantity' => 200,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'fine-toilet-paper-' . Str::random(5),
                'ar' => [
                    'name' => 'مناديل تواليت فاخرة من فاين 3 طبقات',
                    'description' => 'مناديل تواليت ناعمة وقوية 12 رول',
                    'keywords' => ['مناديل', 'تواليت', 'فاين'],
                ],
                'en' => [
                    'name' => 'Fine Deluxe Toilet Paper 3 Layers',
                    'description' => 'Soft and strong toilet paper 12 rolls',
                    'keywords' => ['tissue', 'toilet', 'fine'],
                ],
            ],
            [
                'price' => 449.00,
                'quantity' => 40,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'bluetooth-earbuds-' . Str::random(5),
                'ar' => [
                    'name' => 'سماعات بلوتوث لاسلكية برو',
                    'description' => 'سماعات بلوتوث 5.0 مع علبة شحن',
                    'keywords' => ['سماعات', 'بلوتوث', 'لاسلكية'],
                ],
                'en' => [
                    'name' => 'Wireless Bluetooth Earbuds Pro',
                    'description' => 'Bluetooth 5.0 earbuds with charging case',
                    'keywords' => ['earbuds', 'bluetooth', 'wireless'],
                ],
            ],
            [
                'price' => 899.00,
                'quantity' => 15,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'xiaomi-vacuum-' . Str::random(5),
                'ar' => [
                    'name' => 'مكنسة كهربائية لاسلكية شاومي',
                    'description' => 'مكنسة كهربائية قوية بدون أسلاك',
                    'keywords' => ['مكنسة', 'كهربائية', 'شاومي'],
                ],
                'en' => [
                    'name' => 'Xiaomi Cordless Vacuum Cleaner',
                    'description' => 'Powerful cordless vacuum cleaner',
                    'keywords' => ['vacuum', 'cleaner', 'xiaomi'],
                ],
            ],
            [
                'price' => 175.00,
                'quantity' => 60,
                'category_id' => $category->id,
                'image' => 'default.jpg',
                'slug' => 'glass-food-container-' . Str::random(5),
                'ar' => [
                    'name' => 'حافظة طعام زجاجية 5 قطع',
                    'description' => 'مجموعة حافظات طعام زجاجية مع أغطية محكمة',
                    'keywords' => ['حافظة', 'طعام', 'زجاجية'],
                ],
                'en' => [
                    'name' => 'Glass Food Container Set 5pcs',
                    'description' => 'Glass food storage containers with airtight lids',
                    'keywords' => ['container', 'food', 'glass'],
                ],
            ],
        ];

        foreach ($deals as $deal) {
            Product::create($deal);
        }

        $this->command->info('✓ Added ' . count($deals) . ' sample deal products!');
    }
}

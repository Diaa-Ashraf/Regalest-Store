<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Banner;

class BannersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing banners
        Banner::truncate();

        $banners = [
            [
                'title' => 'خصومات الصيف الكبرى',
                'description' => 'استمتع بخصومات تصل إلى 50% على جميع الملابس الصيفية',
                'image' => 'banners/banner-1.jpg', // We will need to ensure this image exists or use a placeholder
                'url' => '#',
                'position' => 'main_slider',
                'status' => true,
            ],
            [
                'title' => 'أحدث الموبايلات',
                'description' => 'تكنولوجيا المستقبل بين يديك الآن',
                'image' => 'banners/banner-2.jpg',
                'url' => '#',
                'position' => 'main_slider',
                'status' => true,
            ],
             [
                'title' => 'عروض الأجهزة المنزلية',
                'description' => 'جدد بيتك بأفضل الأسعار وأحدث الموديلات',
                'image' => 'banners/banner-3.jpg',
                'url' => '#',
                'position' => 'main_slider',
                'status' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}

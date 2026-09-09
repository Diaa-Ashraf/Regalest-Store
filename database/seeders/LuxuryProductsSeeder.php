<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\File;

class LuxuryProductsSeeder extends Seeder
{
    /**
     * Seed categories and products with images from assets/site/img.
     */
    public function run(): void
    {
        // 1. Ensure storage directories exist
        $sourceDir = public_path('assets/site/img');
        $catStorageDir = storage_path('app/public/categories');
        $prodStorageDir = storage_path('app/public/products');

        if (!File::isDirectory($catStorageDir)) {
            File::makeDirectory($catStorageDir, 0777, true, true);
        }
        if (!File::isDirectory($prodStorageDir)) {
            File::makeDirectory($prodStorageDir, 0777, true, true);
        }

        // Helper to copy an image from assets/site/img to storage/app/public/folder
        $copyToStorage = function (string $sourceFilename, string $targetSubdir, string $destFilename) use ($sourceDir): string {
            $srcPath = $sourceDir . DIRECTORY_SEPARATOR . $sourceFilename;
            $destDir = storage_path('app/public/' . $targetSubdir);
            $destPath = $destDir . DIRECTORY_SEPARATOR . $destFilename;

            if (File::exists($srcPath)) {
                File::copy($srcPath, $destPath);
                return $targetSubdir . '/' . $destFilename;
            }

            return $targetSubdir . '/' . $destFilename;
        };

        // 2. Prepare and copy Category Images
        $catWatchImg = $copyToStorage('ساعات.jpg', 'categories', 'watches-cat.jpg');
        $catBraceletImg = $copyToStorage('انسيال.jpg', 'categories', 'bracelets-cat.jpg');

        // 3. Define Categories
        $categoriesData = [
            [
                'slug' => 'luxury-watches',
                'image' => $catWatchImg,
                'ar' => [
                    'name' => 'ساعات يد فاخرة',
                    'description' => 'تشكيلة راقية من أفخم الساعات الرجالية والنسائية بتصاميم كلاسيكية وعصرية تناسب جميع المناسبات'
                ],
                'en' => [
                    'name' => 'Luxury Watches',
                    'description' => 'Exquisite collection of luxury men and women timepieces designed with supreme elegance'
                ],
            ],
            [
                'slug' => 'luxury-bracelets',
                'image' => $catBraceletImg,
                'ar' => [
                    'name' => 'أساور وإنسيالات راقية',
                    'description' => 'إنسيالات وأساور فاخرة مصممة بعناية فائقة لتضفي لمسة من الأناقة والتألق'
                ],
                'en' => [
                    'name' => 'Luxury Bracelets',
                    'description' => 'Finest collection of elegant bracelets and luxury accessories to elevate your style'
                ],
            ],
        ];

        $categories = [];
        foreach ($categoriesData as $cData) {
            $categories[$cData['slug']] = Category::create($cData);
        }

        $watchesCat = $categories['luxury-watches'];
        $braceletsCat = $categories['luxury-bracelets'];

        // 4. Prepare and copy Product Images
        $imgWatch1 = $copyToStorage('ساعه.jpg', 'products', 'watch-royal-black.jpg');
        $imgWatch2 = $copyToStorage('ساعه1.jpg', 'products', 'watch-classic-gold.jpg');
        $imgWatch3 = $copyToStorage('ساعه2.jpg', 'products', 'watch-silver-chronograph.jpg');
        $imgWatch4 = $copyToStorage('ساعه4.jpg', 'products', 'watch-luxury-edition.jpg');
        $imgWatch5 = $copyToStorage('580031727_122124242258989954_316081771127513242_n.jpg', 'products', 'watch-prestige-chrono.jpg');
        $imgWatch6 = $copyToStorage('580132241_122124307928989954_7871049717021852526_n.jpg', 'products', 'watch-executive-black.jpg');
        $imgWatch7 = $copyToStorage('581353050_122124242180989954_7055632487981440006_n.jpg', 'products', 'watch-silver-diamond.jpg');

        $imgBrac1 = $copyToStorage('انسيال.jpg', 'products', 'bracelet-gold-luxury.jpg');
        $imgBrac2 = $copyToStorage('انسيال2.jpg', 'products', 'bracelet-silver-charm.jpg');
        $imgBrac3 = $copyToStorage('انسال4.jpg', 'products', 'bracelet-royal-mesh.jpg');
        $imgBrac4 = $copyToStorage('582310563_122124242210989954_7818139122037850103_n.jpg', 'products', 'bracelet-prestige-chain.jpg');
        $imgBrac5 = $copyToStorage('582670724_122124242282989954_441150987228824233_n.jpg', 'products', 'bracelet-elegance-gold.jpg');
        $imgBrac6 = $copyToStorage('584061712_122124307838989954_3957257722328916770_n.jpg', 'products', 'bracelet-signature-link.jpg');

        // 5. Define Products
        $productsData = [
            // Watches
            [
                'category_id' => $watchesCat->id,
                'price' => 1450.00,
                'quantity' => 20,
                'stock_quantity' => 20,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgWatch1,
                'slug' => 'regalest-royal-black-dial-watch',
                'ar' => [
                    'name' => 'ساعة ريجاليست رويال بلاك الفاخرة',
                    'description' => 'ساعة يد أوتوماتيكية راقية بهيكل فولاذي أسود مقاوم للصدأ مع ميناء فاخر وزجاج ياقوتي مقاوم للخدوش.',
                    'keywords' => 'ساعة, ريجاليست, أسود, أوتوماتيك, ساعات رجالية',
                ],
                'en' => [
                    'name' => 'Regalest Royal Black Dial Watch',
                    'description' => 'Sophisticated automatic wristwatch with stainless steel black finish and anti-reflective sapphire glass.',
                    'keywords' => 'watch, royal black, luxury, automatic',
                ],
            ],
            [
                'category_id' => $watchesCat->id,
                'price' => 1890.00,
                'quantity' => 15,
                'stock_quantity' => 15,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgWatch2,
                'slug' => 'regalest-prestige-gold-edition',
                'ar' => [
                    'name' => 'ساعة ريجاليست بريستيج إصدار الذهب الملكي',
                    'description' => 'تصميم كلاسيكي ملكي مطلي بالذهب عيار 18 مع حركة ميكانيكية دقيقة ومقاومة عالية للماء.',
                    'keywords' => 'ساعة ذهب, كلاسيك, بريستيج, ريجاليست',
                ],
                'en' => [
                    'name' => 'Regalest Prestige Gold Edition Watch',
                    'description' => 'Classic royal timepiece finished in 18k gold plating with precision mechanical movement.',
                    'keywords' => 'gold watch, luxury, classic, regalest',
                ],
            ],
            [
                'category_id' => $watchesCat->id,
                'price' => 1250.00,
                'quantity' => 25,
                'stock_quantity' => 25,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgWatch3,
                'slug' => 'regalest-silver-chronograph-master',
                'ar' => [
                    'name' => 'ساعة كرونوغراف سيلفر ماستر',
                    'description' => 'ساعة كرونوغراف رياضية كلاسيكية بهيكل فضي مصقول ومينا متدرج الألوان مع عقارب مضيئة.',
                    'keywords' => 'كرونوغراف, فضي, ساعة يد, ريجاليست',
                ],
                'en' => [
                    'name' => 'Regalest Silver Chronograph Master',
                    'description' => 'Sporty classic chronograph watch with polished silver finish and illuminated dials.',
                    'keywords' => 'chronograph, silver watch, master timepiece',
                ],
            ],
            [
                'category_id' => $watchesCat->id,
                'price' => 2100.00,
                'quantity' => 10,
                'stock_quantity' => 10,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgWatch4,
                'slug' => 'regalest-exclusive-limited-edition-watch',
                'ar' => [
                    'name' => 'ساعة ريجاليست الإصدار الخاص المحدود',
                    'description' => 'قطعة فنية نادرة مصممة بحرفية متناهية لعشاق التميز والفخامة الاستثنائية.',
                    'keywords' => 'إصدار محدود, ساعة فاخرة, ريجاليست',
                ],
                'en' => [
                    'name' => 'Regalest Exclusive Limited Edition',
                    'description' => 'A rare collector masterpiece designed with unparalleled horological craftsmanship.',
                    'keywords' => 'limited edition, exclusive watch, luxury',
                ],
            ],
            [
                'category_id' => $watchesCat->id,
                'price' => 1350.00,
                'quantity' => 18,
                'stock_quantity' => 18,
                'is_available' => true,
                'is_active' => true,
                'featured' => false,
                'image' => $imgWatch5,
                'slug' => 'regalest-heritage-chronograph-noir',
                'ar' => [
                    'name' => 'ساعة ريجاليست هيريتيج كرونوغراف نوار',
                    'description' => 'كرونوغراف كلاسيكي متطور بمينا أسود فاخر وسوار متين من الفولاذ غير القابل للصدأ.',
                    'keywords' => 'هيريتيج, كرونوغراف, نوار, ساعات',
                ],
                'en' => [
                    'name' => 'Regalest Heritage Chronograph Noir',
                    'description' => 'Advanced vintage chronograph with deep noir dial and heavy stainless steel bracelet.',
                    'keywords' => 'heritage, chronograph, noir dial',
                ],
            ],
            [
                'category_id' => $watchesCat->id,
                'price' => 1550.00,
                'quantity' => 12,
                'stock_quantity' => 12,
                'is_available' => true,
                'is_active' => true,
                'featured' => false,
                'image' => $imgWatch6,
                'slug' => 'regalest-executive-steel-automatic',
                'ar' => [
                    'name' => 'ساعة ريجاليست إكزكتيف ستيل أوتوماتيك',
                    'description' => 'ساعة رجال الأعمال بتصميم أنيق يلائم الاجتماعات الرسمية والمناسبات الخاصة.',
                    'keywords' => 'إكزكتيف, أوتوماتيك, ستيل, ساعات رجال أعمال',
                ],
                'en' => [
                    'name' => 'Regalest Executive Steel Automatic',
                    'description' => 'Executive business watch crafted for formal occasions and prestigious gatherings.',
                    'keywords' => 'executive, automatic, luxury steel',
                ],
            ],
            [
                'category_id' => $watchesCat->id,
                'price' => 1680.00,
                'quantity' => 14,
                'stock_quantity' => 14,
                'is_available' => true,
                'is_active' => true,
                'featured' => false,
                'image' => $imgWatch7,
                'slug' => 'regalest-diamond-accent-silver-timepiece',
                'ar' => [
                    'name' => 'ساعة ريجاليست دايموند سيلفر الفاخرة',
                    'description' => 'ميناء مرصع بلمسات براقة تعكس الضوء بجمال ساحر مع هيكل فضي فائق اللمعان.',
                    'keywords' => 'دايموند, فضي, ساعات مرصعة, ريجاليست',
                ],
                'en' => [
                    'name' => 'Regalest Diamond Accent Silver Timepiece',
                    'description' => 'Silver timepiece with diamond accents capturing radiance and unmatched brilliance.',
                    'keywords' => 'diamond accent, silver timepiece, elegance',
                ],
            ],

            // Bracelets
            [
                'category_id' => $braceletsCat->id,
                'price' => 450.00,
                'quantity' => 30,
                'stock_quantity' => 30,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgBrac1,
                'slug' => 'regalest-royal-gold-luxury-bracelet',
                'ar' => [
                    'name' => 'إنسيال ريجاليست رويال جولد الفاخر',
                    'description' => 'إنسيال ذهبي ملكي بتصميم أنيق يناسب الإطلالات اليومية والمناسبات الراقية مع قفل آمن متين.',
                    'keywords' => 'إنسيال, ذهب, سوار, إكسسوارات فاخرة',
                ],
                'en' => [
                    'name' => 'Regalest Royal Gold Luxury Bracelet',
                    'description' => 'Royal gold bracelet meticulously crafted with premium clasp for daily and formal wear.',
                    'keywords' => 'gold bracelet, luxury jewelry, regalest',
                ],
            ],
            [
                'category_id' => $braceletsCat->id,
                'price' => 380.00,
                'quantity' => 35,
                'stock_quantity' => 35,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgBrac2,
                'slug' => 'regalest-charm-silver-bracelet',
                'ar' => [
                    'name' => 'إنسيال ريجاليست شارم سيلفر الراقي',
                    'description' => 'إنسيال فضي لامع بنقوش عصرية وتفاصيل دقيقة تضفي لمسة ساحرة على معصمك.',
                    'keywords' => 'إنسيال فضة, شارم, سوار فضي',
                ],
                'en' => [
                    'name' => 'Regalest Charm Silver Bracelet',
                    'description' => 'Shining silver charm bracelet featuring intricate detailing and contemporary flair.',
                    'keywords' => 'silver bracelet, charm, elegant jewelry',
                ],
            ],
            [
                'category_id' => $braceletsCat->id,
                'price' => 520.00,
                'quantity' => 20,
                'stock_quantity' => 20,
                'is_available' => true,
                'is_active' => true,
                'featured' => true,
                'image' => $imgBrac3,
                'slug' => 'regalest-royal-mesh-bracelet',
                'ar' => [
                    'name' => 'سوار ريجاليست رويال ميش المنسوج',
                    'description' => 'سوار ملكي شبكي بتصميم مرن وملمس ناعم مع لمسات مطلية بالذهب.',
                    'keywords' => 'سوار شبكي, رويال ميش, إنسيال ذهبي',
                ],
                'en' => [
                    'name' => 'Regalest Royal Mesh Bracelet',
                    'description' => 'Royal woven mesh bracelet offering exceptional comfort and gold-plated accents.',
                    'keywords' => 'mesh bracelet, woven jewelry, royal gold',
                ],
            ],
            [
                'category_id' => $braceletsCat->id,
                'price' => 490.00,
                'quantity' => 25,
                'stock_quantity' => 25,
                'is_available' => true,
                'is_active' => true,
                'featured' => false,
                'image' => $imgBrac4,
                'slug' => 'regalest-prestige-chain-bracelet',
                'ar' => [
                    'name' => 'إنسيال ريجاليست بريستيج تشين',
                    'description' => 'حلقات متداخلة بانسيابية مميزة تمنحك إطلالة فريدة تجمع بين العصرية والكلاسيكية.',
                    'keywords' => 'بريستيج, تشين, سلسلة, إنسيال رجالي ونسائي',
                ],
                'en' => [
                    'name' => 'Regalest Prestige Chain Bracelet',
                    'description' => 'Seamless interlocking link chain bracelet merging bold aesthetics with luxury.',
                    'keywords' => 'chain bracelet, prestige links, modern jewelry',
                ],
            ],
            [
                'category_id' => $braceletsCat->id,
                'price' => 420.00,
                'quantity' => 28,
                'stock_quantity' => 28,
                'is_available' => true,
                'is_active' => true,
                'featured' => false,
                'image' => $imgBrac5,
                'slug' => 'regalest-elegance-gold-cuff',
                'ar' => [
                    'name' => 'سوار ريجاليست إيليجانس كاف الملكي',
                    'description' => 'سوار كاف مصقول بتشطيب ذهبي لامع يناسب جميع المقاسات بكل راحة.',
                    'keywords' => 'كاف, إيليجانس, سوار ذهب, ريجاليست',
                ],
                'en' => [
                    'name' => 'Regalest Elegance Gold Cuff Bracelet',
                    'description' => 'Polished gold cuff bracelet crafted with a sleek finish for effortless sophistication.',
                    'keywords' => 'gold cuff, elegance bracelet, sleek gold',
                ],
            ],
            [
                'category_id' => $braceletsCat->id,
                'price' => 360.00,
                'quantity' => 40,
                'stock_quantity' => 40,
                'is_available' => true,
                'is_active' => true,
                'featured' => false,
                'image' => $imgBrac6,
                'slug' => 'regalest-signature-link-bracelet',
                'ar' => [
                    'name' => 'إنسيال ريجاليست سيجنتشر لينك',
                    'description' => 'إنسيال راقي بتوقيع ريجاليست يتميز بمتانة عالية ولمعان يدوم طويلاً.',
                    'keywords' => 'سيجنتشر, لينك, إنسيال مميز, إكسسوارات',
                ],
                'en' => [
                    'name' => 'Regalest Signature Link Bracelet',
                    'description' => 'Signature link bracelet representing timeless elegance and durable luxury craftsmanship.',
                    'keywords' => 'signature link, luxury bracelet, iconic jewelry',
                ],
            ],
        ];

        foreach ($productsData as $pData) {
            Product::create($pData);
        }
    }
}

<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Deal;
use App\Models\Bundle;
use App\Repositories\ProductRepository;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    public function __construct(
        protected ProductRepository $productRepo
    ) {}

    /**
     * Homepage with 7 structured luxury sections
     */
    public function index(): View
    {
        // 1. Hero banners (optional top slider)
        $banners = Banner::where('status', true)->orderBy('id', 'desc')->get();

        // 2. Categories with active products count
        $categories = Category::query()
            ->with(['translations'])
            ->withCount('activeProducts')
            ->get();

        // 3. Featured Products / Trending (الأكثر رواجاً / المميزة)
        $trendingProducts = $this->productRepo->getFeatured(16);

        // 4. Daily Flash Deals (العروض اليومية)
        $dealsProducts = $this->productRepo->getDailyDeals(16);

        // Fallback to Deals relation if deals table has items
        $deals = Deal::with(['product.translations', 'product.category.translations'])
            ->active()
            ->ordered()
            ->take(16)
            ->get();

        // 5. Best Sellers (الأكثر مبيعاً)
        $bestSellers = $this->productRepo->getBestSellers(16);

        // 6. Latest Arrivals (المنتجات الجديدة)
        $latestProducts = $this->productRepo->getLatest(16);

        // 7. Featured Categories (الفئات المميزة - 4 to 8 categories with products)
        $featuredCategories = Category::query()
            ->with(['translations'])
            ->withCount('activeProducts')
            ->has('activeProducts')
            ->take(8)
            ->get();

        // If not enough with activeProducts, get any categories
        if ($featuredCategories->isEmpty()) {
            $featuredCategories = $categories->take(8);
        }

        // Bundles (عروض البكجات)
        $bundles = Bundle::with(['products.translations'])
            ->active()
            ->ordered()
            ->take(4)
            ->get();

        return view('site.index', compact(
            'banners',
            'categories',
            'featuredCategories',
            'trendingProducts',
            'dealsProducts',
            'deals',
            'bestSellers',
            'latestProducts',
            'bundles'
        ));
    }

    public function getcategory(): View
    {
        $categories = Category::with('translations')->withCount('activeProducts')->get();
        return view('site.categories', compact('categories'));
    }
}

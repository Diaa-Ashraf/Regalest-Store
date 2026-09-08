<?php

namespace App\Services;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class BundleService
{
    /**
     * Create or update bundle offer with synchronized products and prices
     */
    public function syncBundle(Bundle $bundle, array $productIdsWithQty): Bundle
    {
        return DB::transaction(function () use ($bundle, $productIdsWithQty) {
            $syncData = [];
            $originalTotal = 0.0;

            foreach ($productIdsWithQty as $productId => $qty) {
                $product = Product::find($productId);
                if ($product) {
                    $qty = max(1, (int)$qty);
                    $syncData[$productId] = ['quantity' => $qty];
                    $originalTotal += ((float)$product->price * $qty);
                }
            }

            $bundle->products()->sync($syncData);

            // Recalculate discount percent if bundle_price is set
            $discountPercent = 0;
            if ($originalTotal > 0 && $bundle->bundle_price > 0 && $bundle->bundle_price < $originalTotal) {
                $discountPercent = (int) round((($originalTotal - $bundle->bundle_price) / $originalTotal) * 100);
            }

            $bundle->update([
                'original_total' => $originalTotal,
                'discount_percent' => $discountPercent,
            ]);

            return $bundle->fresh(['products']);
        });
    }
}

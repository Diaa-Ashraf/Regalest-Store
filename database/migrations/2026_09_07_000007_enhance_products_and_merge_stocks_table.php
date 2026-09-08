<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'featured')) {
                $table->boolean('featured')->default(false)->after('category_id');
                $table->index('featured');
            }
            if (!Schema::hasColumn('products', 'discount_price')) {
                $table->decimal('discount_price', 10, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('featured');
                $table->index('is_active');
            }
            if (!Schema::hasColumn('products', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_active');
            }
            if (!Schema::hasColumn('products', 'stock_quantity')) {
                $table->integer('stock_quantity')->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('products', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('stock_quantity');
                $table->index('is_available');
            }
        });

        // Migrate existing stock quantities if stocks table exists
        if (Schema::hasTable('stocks')) {
            $stocks = DB::table('stocks')->get();
            foreach ($stocks as $stock) {
                DB::table('products')->where('id', $stock->product_id)->update([
                    'stock_quantity' => $stock->quantity,
                    'is_available' => $stock->quantity > 0,
                ]);
            }
            Schema::dropIfExists('stocks');
        }
    }

    public function down(): void
    {
        // Recreate stocks table if rolled back
        if (!Schema::hasTable('stocks')) {
            Schema::create('stocks', function (Blueprint $table) {
                $table->id();
                $table->integer('quantity');
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->timestamps();
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'featured',
                'discount_price',
                'is_active',
                'sort_order',
                'stock_quantity',
                'is_available',
            ]);
        });
    }
};

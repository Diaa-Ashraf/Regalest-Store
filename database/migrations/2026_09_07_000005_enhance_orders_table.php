<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->unique()->after('id');
            $table->string('status')->default('pending')->change();
            $table->text('notes')->nullable()->after('payment_method');
            $table->text('cancel_reason')->nullable()->after('notes');
            $table->string('currency', 3)->default('USD')->after('cancel_reason');
            $table->decimal('exchange_rate', 12, 2)->default(1)->after('currency');
            $table->timestamp('confirmed_at')->nullable()->after('exchange_rate');
            $table->timestamp('shipped_at')->nullable()->after('confirmed_at');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
        });

        // If client_id exists, make it nullable so users table transition is smooth
        if (Schema::hasColumn('orders', 'client_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('client_id')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'notes',
                'cancel_reason',
                'currency',
                'exchange_rate',
                'confirmed_at',
                'shipped_at',
                'delivered_at',
                'cancelled_at',
            ]);
        });
    }
};

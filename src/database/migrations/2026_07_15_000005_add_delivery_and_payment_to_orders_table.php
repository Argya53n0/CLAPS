<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('delivery_address')->nullable()->after('notes');
            $table->decimal('delivery_lat', 10, 8)->nullable()->after('delivery_address');
            $table->decimal('delivery_lng', 11, 8)->nullable()->after('delivery_lat');
            $table->integer('shipping_fee')->default(0)->after('total_price');
            $table->enum('payment_method', ['qris', 'cod'])->default('cod')->after('shipping_fee');
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid')->after('payment_method');
            $table->integer('rating')->nullable()->after('payment_status');
            $table->text('review')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_address',
                'delivery_lat',
                'delivery_lng',
                'shipping_fee',
                'payment_method',
                'payment_status',
                'rating',
                'review'
            ]);
        });
    }
};

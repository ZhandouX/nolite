<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('snap_token')->nullable()->after('status');
            $table->string('payment_url')->nullable()->after('snap_token');
            $table->string('midtrans_order_id')->nullable()->after('payment_url');
            $table->string('payment_type')->nullable()->after('midtrans_order_id'); // metode pembayaran dari midtrans
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'payment_url', 'midtrans_order_id', 'payment_type']);
        });
    }
};
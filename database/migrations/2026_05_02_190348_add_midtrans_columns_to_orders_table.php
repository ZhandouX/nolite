<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'snap_token')) {
                $table->string('snap_token')
                    ->nullable()
                    ->after('status');
            }

            if (!Schema::hasColumn('orders', 'payment_url')) {
                $table->string('payment_url')
                    ->nullable()
                    ->after('snap_token');
            }

            if (!Schema::hasColumn('orders', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')
                    ->nullable()
                    ->after('payment_url');
            }

            if (!Schema::hasColumn('orders', 'payment_type')) {
                $table->string('payment_type')
                    ->nullable()
                    ->after('midtrans_order_id');
            }

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            $columns = [
                'snap_token',
                'payment_url',
                'midtrans_order_id',
                'payment_type',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }

        });
    }
};
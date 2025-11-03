<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ulasans', function (Blueprint $table) {
            // Tambahkan kolom order_item_id
            $table->foreignId('order_item_id')
                ->nullable()
                ->constrained('order_items')
                ->onDelete('cascade')
                ->after('order_id');
        });
    }

    public function down(): void
    {
        Schema::table('ulasans', function (Blueprint $table) {
            $table->dropForeign(['order_item_id']);
            $table->dropColumn('order_item_id');
        });
    }
};
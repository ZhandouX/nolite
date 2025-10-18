<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->integer('diskon')->nullable()->default(0)->after('harga'); // persentase diskon
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('diskon');
        });
    }
};

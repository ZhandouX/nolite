<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // PostgreSQL butuh USING untuk konversi string ke JSON
        DB::statement('ALTER TABLE produks ALTER COLUMN warna TYPE JSON USING to_jsonb(warna)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan lagi ke string
        DB::statement('ALTER TABLE produks ALTER COLUMN warna TYPE VARCHAR(250)');
    }
};

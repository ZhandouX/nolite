<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // tambah kolom tsvector
        DB::statement("
            ALTER TABLE produks
            ADD COLUMN search_vector tsvector
        ");

        // isi otomatis data lama
        DB::statement("
            UPDATE produks
            SET search_vector =
                to_tsvector(
                    'indonesian',
                    coalesce(nama_produk,'') || ' ' ||
                    coalesce(deskripsi,'') || ' ' ||
                    coalesce(harga::text,'') || ' ' ||
                    coalesce(warna::text,'') || ' ' ||
                    coalesce(ukuran::text,'')
                )
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE produks
            DROP COLUMN IF EXISTS search_vector
        ");
    }
};

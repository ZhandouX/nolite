<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up()
    {
        // hapus constraint lama
        DB::statement("
            ALTER TABLE orders
            DROP CONSTRAINT IF EXISTS orders_status_check;
        ");

        // buat constraint baru
        DB::statement("
            ALTER TABLE orders
            ADD CONSTRAINT orders_status_check
            CHECK (
                status IN (
                    'menunggu',
                    'diproses',
                    'dikirim',
                    'selesai',
                    'dibatalkan'
                )
            );
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE orders
            DROP CONSTRAINT IF EXISTS orders_status_check;
        ");

        DB::statement("
            ALTER TABLE orders
            ADD CONSTRAINT orders_status_check
            CHECK (
                status IN (
                    'menunggu',
                    'diproses',
                    'dikirim',
                    'selesai'
                )
            );
        ");
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        DB::statement("
        ALTER TABLE orders
        DROP CONSTRAINT orders_status_check;
    ");

        DB::statement("
        ALTER TABLE orders
        ADD CONSTRAINT orders_status_check
        CHECK (status IN (
            'menunggu',
            'menunggu_pembayaran',
            'diproses',
            'dikirim',
            'selesai',
            'dibatalkan'
        ));
    ");
    }

    public function down()
    {
        DB::statement("
        ALTER TABLE orders
        DROP CONSTRAINT orders_status_check;
    ");

        DB::statement("
        ALTER TABLE orders
        ADD CONSTRAINT orders_status_check
        CHECK (status IN (
            'menunggu',
            'diproses',
            'dikirim',
            'selesai'
        ));
    ");
    }
};
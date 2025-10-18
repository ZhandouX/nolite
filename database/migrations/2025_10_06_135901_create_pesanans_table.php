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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (pembeli)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Informasi pengiriman
            $table->string('nama_penerima');
            $table->string('email')->nullable();
            $table->string('no_hp');
            $table->string('negara')->default('Indonesia');
            $table->string('kota');
            $table->text('alamat_detail');
            $table->boolean('is_dropship')->default(false);

            // Catatan tambahan
            $table->text('catatan')->nullable();

            // Metode pembayaran
            $table->string('metode_pembayaran')->nullable();

            // Total pembayaran
            $table->decimal('total_harga', 15, 2)->default(0);

            // Status pesanan
            $table->enum('status', ['pending', 'dibayar', 'dikirim', 'selesai', 'batal'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};

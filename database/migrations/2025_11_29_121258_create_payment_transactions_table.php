<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('reference'); // Merchant Order ID
            $table->string('merchant_order_id')->nullable(); // Duitku's order ID
            $table->string('payment_method')->nullable();
            $table->string('payment_name')->nullable();
            $table->decimal('amount', 15, 2);
            $table->decimal('fee', 15, 2)->default(0);
            $table->string('status')->default('menunggu'); // menunggu, selesai, dibatalkan
            $table->text('payment_url')->nullable();
            $table->text('callback_data')->nullable();
            $table->timestamp('expired_time')->nullable();
            $table->timestamps();

            $table->index(['reference']);
            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
};
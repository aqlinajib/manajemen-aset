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
        Schema::create('transaksi_aset_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaksi_aset_id');
            $table->string('progress')->nullable();
            $table->string('activity');
            $table->unsignedBigInteger('user_id')->nullable(); // jika ingin tahu siapa yang input/edit
            $table->timestamps();
    
            $table->foreign('transaksi_aset_id')->references('id')->on('transaksi_asets')->onDelete('cascade');
            // user_id bisa juga pakai foreign ke users table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_aset_histories');
    }
};
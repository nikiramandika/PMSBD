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
        Schema::create('log_pembatalan', function (Blueprint $table) {
            $table->id();
            $table->integer('transaksi_id');
            $table->string('alasan', 255);
            $table->string('dibatalkan_oleh', 255)->nullable();
            $table->timestamp('deleted_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_pembatalan');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id(); // id_pesanan
            $table->foreignId('pelanggan_id')->constrained('users'); // hanya pelanggan
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->bigInteger('total_pesanan');

            // Ubah enum jadi 3 status sesuai permintaan
            $table->enum('status_pesanan', ['belum bayar', 'menunggu konfirmasi', 'lunas'])->default('belum bayar');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanans'); // ini diperbaiki dari sebelumnya
    }
};

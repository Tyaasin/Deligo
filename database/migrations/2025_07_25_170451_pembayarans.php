<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id(); // id_pembayaran
            $table->foreignId('pesanan_id')->constrained('pesanans');
            $table->foreignId('pegawai_id')->nullable()->constrained('users'); // kasir
            $table->timestamp('tanggal_pembayaran')->useCurrent();
            $table->bigInteger('total_pembayaran');
            $table->enum('jenis_pembayaran', ['transfer', 'qris']);
            $table->enum('status_pembayaran', ['belum bayar', 'menunggu konfirmasi', 'selesai'])->default('belum bayar'); // diseragamkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

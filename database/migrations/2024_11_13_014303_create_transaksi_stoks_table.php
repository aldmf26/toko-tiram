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
        Schema::create('transaksi_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_id');
            $table->enum('jenis_transaksi', ['stok_masuk', 'penjualan', 'opname']);
            $table->integer('jumlah');  // Jumlah unit yang ditambah/kurang (positif atau negatif)
            $table->integer('stok_sebelum'); // Stok sebelum transaksi
            $table->integer('stok_setelah'); // Stok setelah transaksi
            $table->integer('urutan');
            $table->string('no_invoice')->nullable();
            $table->string('dijual_ke')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamp('tanggal')->useCurrent();
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
        Schema::dropIfExists('transaksi_stoks');
    }
};

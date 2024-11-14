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
        Schema::table('transaksi_stoks', function (Blueprint $table) {
            $table->string('admin')->after('keterangan')->nullable(); // Menambah kolom admin setelah keterangan
            $table->double('ttl_rp')->after('stok_setelah')->nullable(); // Menambah kolom admin setelah keterangan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_stoks', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::create('produk_tags', function (Blueprint $table) {
            $table->foreignId('id_produk')->constrained('produks')->onDelete('restrict');
            $table->foreignId('id_tag')->constrained('tags')->onDelete('restrict');

            $table->primary(['id_produk', 'id_tag']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produk_tags');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_id');
            $table->string('nama_produk');
            $table->string('stok_produk', 20);
            $table->string('harga_produk', 15);
            $table->string('ukuran_produk');
            $table->string('variasi_produk');
            $table->string('foto_produk');
            $table->mediumText('deskripsi_produk');
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
        Schema::dropIfExists('produks');
    }
}

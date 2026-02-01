<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nama produk
            $table->integer('category_id');      // Kategori: Makanan/Minuman
            $table->text('description');     // Deskripsi produk
            $table->integer('price');        // Harga
            $table->integer('stock');        // Stok
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};

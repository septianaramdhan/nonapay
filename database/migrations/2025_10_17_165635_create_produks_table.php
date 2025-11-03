<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
{
    Schema::create('produks', function (Blueprint $table) {
        $table->id('id_produk');
        $table->unsignedBigInteger('id_kasir');
        $table->string('nama_produk');
        $table->decimal('harga', 12, 2);
        $table->integer('stok')->default(0);
        $table->timestamps();

        $table->foreign('id_kasir')->references('id_kasir')->on('kasirs')->onDelete('cascade');
    });
}

    public function down() {
        Schema::dropIfExists('products');
    }
};

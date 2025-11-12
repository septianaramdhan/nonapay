<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
   {
       Schema::create('detail_transaksis', function (Blueprint $table) {
           $table->id('id_detail');
           $table->unsignedBigInteger('id_transaksi');
           $table->unsignedBigInteger('id_produk')->nullable(); // 🩶 nullable, biar aman kalau produk dihapus permanen

           // 🧊 snapshot data produk saat transaksi
           $table->string('nama_produk'); 
           $table->decimal('harga_saat_transaksi', 12, 2);

           $table->integer('jumlah');
           $table->decimal('subtotal', 12, 2);
           $table->timestamps();

           // relasi transaksi tetap
           $table->foreign('id_transaksi')
                 ->references('id_transaksi')
                 ->on('transaksis')
                 ->onDelete('cascade');

           // relasi produk (biar aman walau produk udah dihapus soft delete)
           $table->foreign('id_produk')
                 ->references('id_produk')
                 ->on('produks')
                 ->onDelete('set null'); // 🩶 ubah ke set null, biar detail gak kehapus
       });
   }

   public function down(): void
   {
       Schema::dropIfExists('detail_transaksis');
   }
};

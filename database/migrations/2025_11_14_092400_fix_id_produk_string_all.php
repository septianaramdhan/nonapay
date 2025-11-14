<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    // 1. DROP foreign key dulu
    Schema::table('detail_transaksis', function (Blueprint $table) {
        $table->dropForeign('detail_transaksis_id_produk_foreign');
    });

    // 2. Ubah kolom di tabel produks
    Schema::table('produks', function (Blueprint $table) {
        $table->string('id_produk')->change(); 
    });

    // 3. Ubah kolom di detail_transaksis juga
    Schema::table('detail_transaksis', function (Blueprint $table) {
        $table->string('id_produk')->nullable()->change();
    });

    // 4. Tambah foreign key lagi
    Schema::table('detail_transaksis', function (Blueprint $table) {
        $table->foreign('id_produk')
              ->references('id_produk')
              ->on('produks')
              ->onDelete('set null');
    });
}

public function down()
{
    // Kembalikan ke semula
    Schema::table('detail_transaksis', function (Blueprint $table) {
        $table->dropForeign(['id_produk']);
    });

    Schema::table('detail_transaksis', function (Blueprint $table) {
        $table->unsignedBigInteger('id_produk')->nullable()->change();
    });

    Schema::table('produks', function (Blueprint $table) {
        $table->unsignedBigInteger('id_produk')->change();
    });

    Schema::table('detail_transaksis', function (Blueprint $table) {
        $table->foreign('id_produk')
              ->references('id_produk')
              ->on('produks')
              ->onDelete('set null');
    });
}

};

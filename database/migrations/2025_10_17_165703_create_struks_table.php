<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   public function up(): void
{
    Schema::create('struks', function (Blueprint $table) {
        $table->id('id_struk');
        $table->unsignedBigInteger('id_transaksi');
        $table->date('tanggal_cetak');
        $table->timestamps();

        $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksis')->onDelete('cascade');
    });
}

    public function down() {
        Schema::dropIfExists('receipts');
    }
};

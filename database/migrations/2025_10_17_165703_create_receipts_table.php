<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade')->unique();
            $table->dateTime('tanggal_cetak')->useCurrent();
            $table->decimal('total', 12, 2)->nullable();
            $table->enum('metode_payment', ['Cash','Transfer'])->nullable();
            $table->decimal('kembalian', 12, 2)->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('receipts');
    }
};

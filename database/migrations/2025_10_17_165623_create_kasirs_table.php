<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('kasirs', function (Blueprint $table) {
        $table->id('id_kasir');
        $table->string('nama_kasir');
        $table->string('username')->unique();
        $table->string('password');
        $table->timestamps();
    });


    }

    public function down(): void
    {
        Schema::dropIfExists('kasirs');
    }
};

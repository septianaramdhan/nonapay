<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('struks', function (Blueprint $table) {
            $table->string('id_struk')->change();
        });
    }

    public function down(): void
    {
        Schema::table('struks', function (Blueprint $table) {
            $table->bigIncrements('id_struk')->change();
        });
    }
};

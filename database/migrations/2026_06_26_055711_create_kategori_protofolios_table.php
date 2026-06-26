<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kategori_protofolios', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid', 50)->unique();
            $table->string('name_kategori_id', 100);
            $table->string('name_kategori_en', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_protofolios');
    }
};

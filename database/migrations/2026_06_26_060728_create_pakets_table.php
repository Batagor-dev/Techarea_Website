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
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 50)->unique();
            $table->foreignId('kategori_paket_id')->constrained('kategori_pakets')->onDelete('cascade');
            $table->foreignId('kelas_paket_id')->constrained('kelas_pakets')->onDelete('cascade');
            $table->string('name_paket_id');
            $table->string('name_paket_en');
            $table->text('description_paket_id');
            $table->text('description_paket_en');
            $table->integer('price_paket');
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pakets');
    }
};

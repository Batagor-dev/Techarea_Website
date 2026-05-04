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
        Schema::create('sertifikats', function (Blueprint $table) {
             $table->id();
            $table->string('slug', 50)->unique();
            $table->string('name_sertifikat_id', 100);
            $table->string('name_sertifikat_en', 100);
            $table->string('image');
            $table->date('published_at');
            $table->text('deskripsi_id');
            $table->text('deskripsi_en');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};

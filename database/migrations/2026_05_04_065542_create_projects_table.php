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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid', 50)->unique();
            $table->foreignId('kategori_project_id')->constrained('kategori_projects')->onDelete('cascade');
            $table->string('name_project', 100);
            $table->string('deskripsi_project')->nullable();
            $table->enum('status_project', [
                'pending',
                'dikerjakan',
                'selesai',
                'dibatalkan'
            ])->default('pending');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

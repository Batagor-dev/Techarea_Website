<?php

namespace App\Observers;

use App\Models\KategoriPortofolio;
use App\Services\GeminiTranslationService;

class KategoriPortofolioObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(KategoriPortofolio $kategori_portofolio)
    {
        // Auto-translate Nama Project
        // Jalankan jika: (Bahasa EN kosong) ATAU (Bahasa ID berubah/baru saja diedit)
        if (!empty($kategori_portofolio->name_kategori_project_id) && ($kategori_portofolio->isDirty('name_kategori_project_id') || empty($kategori_portofolio->name_kategori_project_en))) {
            $kategori_portofolio->name_kategori_project_en = $this->gemini->translate($kategori_portofolio->name_kategori_project_id);
        }
    }
}
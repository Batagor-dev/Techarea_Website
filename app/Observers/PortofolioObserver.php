<?php

namespace App\Observers;

use App\Models\Portofolio;
use App\Services\GeminiTranslationService;

class PortofolioObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(Portofolio $portofolio)
    {
        // Auto-translate Nama Project
        // Jalankan jika: (Bahasa EN kosong) ATAU (Bahasa ID berubah/baru saja diedit)
        if (!empty($portofolio->name_project_id) && ($portofolio->isDirty('name_project_id') || empty($portofolio->name_project_en))) {
            $portofolio->name_project_en = $this->gemini->translate($portofolio->name_project_id);
        }

        // Auto-translate Deskripsi
        // Jalankan jika: (Deskripsi EN kosong) ATAU (Deskripsi ID berubah)
        if (!empty($portofolio->deskripsi_id) && ($portofolio->isDirty('deskripsi_id') || empty($portofolio->deskripsi_en))) {
            $portofolio->deskripsi_en = $this->gemini->translate($portofolio->deskripsi_id);
        }
    }
}
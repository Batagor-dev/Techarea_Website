<?php

namespace App\Observers;

use App\Models\Paket;
use App\Services\GeminiTranslationService;

class PaketObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(Paket $paket)
    {
        // Auto-translate Nama Project
        // Jalankan jika: (Bahasa EN kosong) ATAU (Bahasa ID berubah/baru saja diedit)
        if (!empty($paket->name_paket_id) && ($paket->isDirty('name_paket_id') || empty($paket->name_paket_en))) {
            $paket->name_paket_en = $this->gemini->translate($paket->name_paket_id);
        }

        // Auto-translate Deskripsi
        // Jalankan jika: (Deskripsi EN kosong) ATAU (Deskripsi ID berubah)
        if (!empty($paket->description_paket_id) && ($paket->isDirty('description_paket_id') || empty($paket->description_paket_en))) {
            $paket->description_paket_en = $this->gemini->translate($paket->description_paket_id);
        }
    }
}
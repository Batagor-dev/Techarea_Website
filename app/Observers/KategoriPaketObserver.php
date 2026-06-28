<?php

namespace App\Observers;

use App\Models\KategoriPaket;
use App\Services\GeminiTranslationService;

class KategoriPaketObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(KategoriPaket $kategori_paket)
    {
        // Auto-translate Nama Project
        // Jalankan jika: (Bahasa EN kosong) ATAU (Bahasa ID berubah/baru saja diedit)
        if (!empty($kategori_paket->name_kategori_paket_id) && ($kategori_paket->isDirty('name_kategori_paket_id') || empty($kategori_paket->name_kategori_paket_en))) {
            $kategori_paket->name_kategori_paket_en = $this->gemini->translate($kategori_paket->name_kategori_paket_id);
        }
    }
}
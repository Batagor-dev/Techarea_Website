<?php

namespace App\Observers;

use App\Models\KelasPaket;
use App\Services\GeminiTranslationService;

class KelasPaketObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(KelasPaket $kelas_paket)
    {
        // Auto-translate Nama Project
        // Jalankan jika: (Bahasa EN kosong) ATAU (Bahasa ID berubah/baru saja diedit)
        if (!empty($kelas_paket->name_kelas_paket_id) && ($kelas_paket->isDirty('name_kelas_paket_id') || empty($kelas_paket->name_kelas_paket_en))) {
            $kelas_paket->name_kelas_paket_en = $this->gemini->translate($kelas_paket->name_kelas_paket_id);
        }
    }
}
<?php

namespace App\Observers;

use App\Models\Sertifikat;
use App\Services\GeminiTranslationService;

class SertifikatObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(Sertifikat $sertifikat)
    {
        // Auto-translate Nama Sertifikat
        // Berjalan jika: Nama EN kosong ATAU Nama ID baru saja diubah
        if (!empty($sertifikat->name_sertifikat_id) && 
            (empty($sertifikat->name_sertifikat_en) || $sertifikat->isDirty('name_sertifikat_id'))) {
            
            $sertifikat->name_sertifikat_en = $this->gemini->translate($sertifikat->name_sertifikat_id);
        }

        // Auto-translate Deskripsi
        // Berjalan jika: Deskripsi EN kosong ATAU Deskripsi ID baru saja diubah
        if (!empty($sertifikat->deskripsi_id) && 
            (empty($sertifikat->deskripsi_en) || $sertifikat->isDirty('deskripsi_id'))) {
            
            $sertifikat->deskripsi_en = $this->gemini->translate($sertifikat->deskripsi_id);
        }
    }
}
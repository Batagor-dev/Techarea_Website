<?php

namespace App\Observers;

use App\Models\Testimoni;
use App\Services\GeminiTranslationService;

class TestimoniObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

public function saving(Testimoni $testimoni)
{
    \Log::info('Observer Saving Testimoni');

    if (
        !empty($testimoni->testimoni_client_id) &&
        ($testimoni->isDirty('testimoni_client_id') || empty($testimoni->testimoni_client_en))
    ) {

        \Log::info('Masuk translate');

        $testimoni->testimoni_client_en = $this->gemini->translate(
            $testimoni->testimoni_client_id
        );
    }
}
}
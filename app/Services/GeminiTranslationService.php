<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;

class GeminiTranslationService
{
    public function translate($text)
{
    \Log::info('Memulai translasi untuk: ' . $text);

    if (empty($text)) return $text;

    try {
        $prompt = "Translate this text from Indonesian to English. Provide ONLY the direct translation text without any explanations or quotes:\n\n" . $text;

        // Gunakan gemini-2.5-flash 
        $result = Gemini::generativeModel('gemini-2.5-flash')
            ->generateContent($prompt);

        return trim($result->text()) ?: $text;

    } catch (\Exception $e) {
        // Cek jika error karena overload/high demand
        if (str_contains($e->getMessage(), 'high demand') || str_contains($e->getMessage(), '429')) {
            \Log::warning('Gemini sedang sibuk, mencoba fallback atau kembalikan teks asli.');
        }
        
        \Log::error('Gemini Translation Error: ' . $e->getMessage());
        return $text;
    }
}
}
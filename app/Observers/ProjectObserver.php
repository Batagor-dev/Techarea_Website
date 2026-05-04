<?php

namespace App\Observers;

use App\Models\Project;
use App\Services\GeminiTranslationService;

class ProjectObserver
{
    protected $gemini;

    public function __construct(GeminiTranslationService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function saving(Project $project)
    {
        // Auto-translate Nama Project
        // Jalankan jika: (Bahasa EN kosong) ATAU (Bahasa ID berubah/baru saja diedit)
        if (!empty($project->name_project_id) && ($project->isDirty('name_project_id') || empty($project->name_project_en))) {
            $project->name_project_en = $this->gemini->translate($project->name_project_id);
        }

        // Auto-translate Deskripsi
        // Jalankan jika: (Deskripsi EN kosong) ATAU (Deskripsi ID berubah)
        if (!empty($project->deskripsi_id) && ($project->isDirty('deskripsi_id') || empty($project->deskripsi_en))) {
            $project->deskripsi_en = $this->gemini->translate($project->deskripsi_id);
        }
    }
}
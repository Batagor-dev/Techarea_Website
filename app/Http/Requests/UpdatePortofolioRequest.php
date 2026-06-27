<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortofolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_project_id' => 'required|string|max:255',
            'name_project_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'link_demo' => 'nullable|url|max:255',
            'deskripsi_id' => 'required|string',
            'deskripsi_en' => 'nullable|string',
            'kategori_portofolio_id' => 'nullable|exists:kategori_portofolios,id',
        ];
    }
}

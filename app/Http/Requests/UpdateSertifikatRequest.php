<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSertifikatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_sertifikat_id' => 'required|string|max:100',
            'name_sertifikat_en' => 'nullable|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'published_at' => 'required|date|before_or_equal:today',

            'deskripsi_id' => 'required|string',
            'deskripsi_en' => 'nullable|string',
        ];
    }
}
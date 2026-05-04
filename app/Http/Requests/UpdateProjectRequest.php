<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
   public function rules()
    {
        return [
            'name_project_id' => 'required|string|max:100',
            'name_project_en' => 'nullabe|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'technology' => 'required|array',
            'technology.*' => 'string|max:50',

            'link_demo' => 'nullable|url',

            'deskripsi_id' => 'required|string',
            'deskripsi_en' => 'nullable|string',
        ];
    }
}

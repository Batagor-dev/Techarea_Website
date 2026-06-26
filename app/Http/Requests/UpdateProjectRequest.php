<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'kategori_project_id' => 'required|exists:kategori_projects,id',
            'name_project' => 'required|string|max:100',
            'deskripsi_project' => 'nullable|string',
            'status_project' => 'required|in:pending,dikerjakan,selesai,dibatalkan',
        ];
    }
}

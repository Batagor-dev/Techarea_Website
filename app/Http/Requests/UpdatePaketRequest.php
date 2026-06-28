<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('pakets', 'slug')->ignore($this->paket),
            ],

            'kategori_paket_id' => [
                'required',
                'exists:kategori_pakets,id',
            ],

            'kelas_paket_id' => [
                'required',
                'exists:kelas_pakets,id',
            ],

            'name_paket_id' => [
                'required',
                'string',
                'max:100',
            ],

            'name_paket_en' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description_paket_id' => [
                'required',
                'string',
            ],

            'description_paket_en' => [
                'nullable',
                'string',
            ],

            'price_paket' => [
                'required',
                'numeric',
                'min:0',
            ],

            'is_popular' => [
                'required',
                'boolean',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ];
    }
}
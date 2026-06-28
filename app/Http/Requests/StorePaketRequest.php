<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'price_paket' => str_replace('.', '', $this->price_paket),
        ]);
    }

    public function rules(): array
    {
        return [
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

            'description_paket_id' => [
                'required',
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
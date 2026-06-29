<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            // Client
            'company_client' => 'required|string|max:255',
            'name_client' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',

            // Invoice
            'payment_method_id' => 'required|exists:payment_methods,id',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'project_amount' => 'required|numeric|min:0',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'payment_status' => 'required|string|max:255',
            'payment_date' => 'nullable|date',
            'payment_amount' => 'nullable|numeric|min:0',

            // Invoice Items
            'item_name' => 'required|array|min:1',
            'item_name.*' => 'required|string|max:255',

            'item_description' => 'required|array|min:1',
            'item_description.*' => 'required|string',

            'item_price' => 'required|array|min:1',
            'item_price.*' => 'required|numeric|min:0',

        ];
    }
}
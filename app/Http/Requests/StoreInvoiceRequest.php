<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Clients
            'company_client' => 'required|string|max:255',
            'name_client' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',


            // Invoice
            'client_id' => 'nullable|exists:clients,id',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            // 'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'project_amount' => 'required|numeric',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'payment_status' => 'required|string|max:255',
            'payment_date' => 'nullable|date',
            'payment_amount' => 'nullable|numeric',
            
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

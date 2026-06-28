<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
            'name_payment_method' => 'required|string|max:70|unique:payment_methods,name_payment_method,' . $this->route('payment')->uuid . ',uuid',
            'type_payment_method' => 'required|max:70',
            'account_name' => 'required|max:70',
            'account_number' => 'required|max:70',
            'is_active' => 'required|in:0,1',
        ];
    }
}

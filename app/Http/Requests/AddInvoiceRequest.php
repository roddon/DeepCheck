<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddInvoiceRequest extends FormRequest
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
            'invoice_file' => 'required|max:4096',
            'invoice_file.*' => 'mimes:jpeg,jpg,png,pdf|max:4096'
        ];
    }

    public function messages() {
        return [
            'invoice_file.*.max' => 'File size should be less than 4mb',
            'invoice_file.*.mimes' => 'Only jpeg, jpg, png, pdf files are allowed.',
            'invoice_file.max' => 'File size should be less than 4mb'
        ];
    }
}

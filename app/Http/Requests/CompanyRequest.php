<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'company_name' => 'required',
            'address' => '',
            'contact1' => 'required',
            'contact2' => '',
            'description' => '',
            'logo' => 'mimes:jpg,jpeg,png|max:5048',
            'date_of_registeration' => '',
        ];
    }
}

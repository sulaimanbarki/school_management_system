<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AllowanceRequest extends FormRequest
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
            'allowancename' => 'required|string|min:1',
            'allawanceamount' => 'required|integer|min:1',
            'allowancedescription' => 'string|min:1',
            'allowancescale' => 'required|exists:scales,id',
            'allowancetype' => 'in:PLUS,MINUS',
            'allownaceacademinsession' => 'required|exists:scales,id',
            'eobiamount' => '',
        ];
    }
}

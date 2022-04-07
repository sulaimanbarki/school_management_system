<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffSalaryDetailsRequest extends FormRequest
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
            'employeeid' => 'required|exists:admins,id',
            'allowanceid' => 'required|exists:allowances,id',
            'amount' => 'required',
            'type' => 'required|in:PLUS,MINUS',
            'date' => '',
            'description' => '',
            'isactive' => 'required',
        ];
    }
}

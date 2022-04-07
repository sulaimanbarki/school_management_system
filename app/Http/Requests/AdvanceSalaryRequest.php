<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvanceSalaryRequest extends FormRequest
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
            'employeeidadvancesalary' => 'required|exists:admins,id',
            'debitamount' => 'required',
            'status' => 'in:0,1',
            'advancesalarydate' => 'required',
        ];
    }
}

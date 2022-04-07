<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'expense_head_idd' => 'required',
            'expense_desc' => '',
            // 'departmmentsequence' => 'required',
            'expense_date' => '',
            'expense_amount' => 'required|integer'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScaleRequest extends FormRequest
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
            'scalename' => 'required',
            'scaledescription' => '',
            'basicpay' => 'required',
            'yearlyincrement' => '',
            'academicsession' => 'required',
            'salarylimit' => '',
            'leaveAmount' => '',
            'leaveStatus' => '',
            'isactive' => 'in:1,0',
            'sequence' => 'required|integer|between:1,20'
        ];
    }
}

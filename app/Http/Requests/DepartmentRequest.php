<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'title' => 'required',
            'departmentdescription' => '',
            // 'departmmentsequence' => 'required',
            'departmentisdisplay' => 'required|in:1,0',
            'departmmentsequence' => 'required|integer|between:1,20'
        ];
    }
}

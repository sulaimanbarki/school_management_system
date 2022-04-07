<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
            'main_category_name' => 'required',
            'company_id' => 'required|exists:companies,id',
            'date' => '',
            'isdisplay' => 'required|in:1,0',
            'sequence' => 'required|integer|between:1,20',
        ];
    }
}

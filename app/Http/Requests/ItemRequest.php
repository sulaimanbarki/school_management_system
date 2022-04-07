<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'itemcode' => 'required|string|max:255',
            'item_name' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'unit' => 'required',
            'purchase_price' => 'required|integer',
            'sale_price' => 'required|integer',
            'qty' => 'required|integer',
            'isdisplay' => 'required|in:1,0',
            'sequence' => 'required|integer|between:1,20',
        ];
    }
}

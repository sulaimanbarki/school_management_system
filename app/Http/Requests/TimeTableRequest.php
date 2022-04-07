<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeTableRequest extends FormRequest
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
            'empid' => 'required|exists:admins,id',
            'classid' => 'required|exists:classes,C_id',
            'sectionid' => 'required|exists:sections,Sec_ID',
            'subjectid' => 'required|exists:subjects,id',
            'locationid' => 'required|exists:locations,id',
            'timeid' => 'required|exists:times,id',
            'sequence' => 'required|integer|between:1,20',
            'isdisplay' => 'required',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            //
            "name_en"=>'required|string|max:100',
            "name_ar"=>'required|string|max:100',
            "category_id"=>'required|exists:categories,id'
        ];
    }
    public function messages()
    {
        return[
            "name_en"=>'required feild',
            "name_ar"=>'required feild',
            "category_id"=>'must exist'
        ];
    }
}

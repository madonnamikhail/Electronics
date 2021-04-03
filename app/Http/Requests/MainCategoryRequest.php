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
            //
            'name_en'=>'required|string|max:100|unique:categories,name_en',
            'name_ar'=>'required|string|max:100|unique:categories,name_ar',
            'photo'=>'required|mimes:png,jpg,jpeg'
        ];
    }

    public function messages()
    {
        return [
            //
            'name_en'=>'English name is required',
            'name_ar'=>'Arabic name is required',
            'photo'=>'photo is required'
        ];
    }
}

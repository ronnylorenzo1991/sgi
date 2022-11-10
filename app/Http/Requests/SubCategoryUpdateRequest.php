<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryUpdateRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:subcategories,name,'.request()->id,
            'description' => 'required',
        ];
        return $rules;
    }

    public function attributes()
    {
        return [
            'name'=> 'Nombre',
            'description'=> 'Descripción',
        ];
    }
}

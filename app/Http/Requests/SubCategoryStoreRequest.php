<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryStoreRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:subcategories,name',
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

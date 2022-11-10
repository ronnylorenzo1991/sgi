<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvailabilityStoreRequest extends FormRequest
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
            'site_id'      => 'required',
            'description'  => 'required',
            'availability' => 'required|numeric|between:0,100',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'site_id'      => 'Sitio Web',
            'description'  => 'Descripción',
            'availability' => 'Dispnibilidad',
        ];
    }

    public function messages()
    {
        return [
            'between' => 'El campo :attributedebe ser un valor entre :min - :max.',
        ];
    }
}

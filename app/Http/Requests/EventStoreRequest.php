<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'date'           => 'required|date',
            'number'         => 'required|unique:events,number,'.request()->id,
            'category_id'    => 'required',
            'observations'   => 'required',
            'detected_by_id' => 'required',
            'subcategory_id' => 'required',
            'contribute_id'  => 'required',
            'foreign_nodes'  => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'date'           => 'Fecha',
            'number'         => 'Número',
            'category_id'    => 'Categoría',
            'observations'   => 'Observaciones',
            'detected_by_id' => 'Detectado Por',
            'subcategory_id' => 'Subcategoría',
            'contribute_id'  => 'Tributa',
            'foreign_nodes'  => 'Direcciónes Extranjeras',
            'national_nodes' => 'Direcciónes Nacionales',
        ];
    }

    public function messages()
    {
        return [
            'integer'  => 'El atributo :attribute debe ser un Número valido',
        ];
    }
}

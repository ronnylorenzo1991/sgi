<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'date'             => 'required|date',
            'number'           => 'required|unique:events,number,'.request()->id,
            'category_id'      => 'required',
            'observations'     => 'required',
            'detected_by_id'   => 'required',
            'subcategory_id'   => 'required',
            'contribute_id'    => 'required',
            'internet_link_id' => 'required',
            'country_id'       => 'required',
            'ministry_id'      => 'required',
            'ips'              => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'date'             => 'Fecha',
            'number'           => 'Número',
            'category_id'      => 'Categoría',
            'observations'     => 'Observaciones',
            'detected_by_id'   => 'Detectado Por',
            'subcategory_id'   => 'Subcategoría',
            'contribute_id'    => 'Tributa',
            'internet_link_id' => 'Enlace',
            'country_id'       => 'Entidad',
            'ministry_id'      => 'Ministerio',
            'ips'              => 'Ips',
        ];
    }
}

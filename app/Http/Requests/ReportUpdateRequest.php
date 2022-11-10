<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportUpdateRequest extends FormRequest
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
            'number'         => 'required',
            'events'    => 'required',
            'news'   => 'required',
            'availabilities' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'date'           => 'Fecha',
            'number'         => 'Número',
            'events'    => 'Eventos',
            'news'   => 'Fuentes Públicas Informativas',
            'availabilities' => 'Disponibilidad de Sitios Web',
        ];
    }
}

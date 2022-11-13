<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
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
            'number'     => 'required',
            'startDate' => 'required',
            'endDate'   => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'site_id'    => 'Número',
            'start_date' => 'Fecha Inicio',
            'end_date'   => 'Fecha Fin',
        ];
    }

    public function messages()
    {
        return [
            'between' => 'El campo :attributedebe ser un valor entre :min - :max.',
        ];
    }
}

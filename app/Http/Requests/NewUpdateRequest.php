<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUpdateRequest extends FormRequest
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
            'title'           => 'required',
            'body'         => 'required',
            'url'    => 'required|url|unique:news,url,'.request()->id,
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'title'           => 'Títilo',
            'body'         => 'Cuerpo de la Noticia',
            'url'    => 'URL',
        ];
    }

    public function messages()
    {
        return [
            'url' => 'El campo :attribute debe tener la siguiente estructura: http o https://servidor..',
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DemandeRequest extends Request
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
            'titre' => 'required',
            'content' => 'required',
            'dateEvent' => 'required',
            'dateEndEvent' => 'required',
            'langue_src' => 'required',
            'langue_dest' => 'required',
            'client' => 'required',
            'adresse' => 'required',
            'lat' => 'required',
            'long' => 'required'
        ];
    }
}

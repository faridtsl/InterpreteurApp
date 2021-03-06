<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class InterpreteurRequest extends Request{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'nom' => 'required',
            'prenom' => 'required',
            'email' => 'required|email|unique:interpreteurs',
            'tel_portable' => 'required',
            'adresse' => 'required',
            'langue_src' => 'required',
            'langue_dest' => 'required',
            'prestation' => 'required|Integer|Min:0',
            'lat' => 'required',
            'long' => 'required'
        ];
    }
}

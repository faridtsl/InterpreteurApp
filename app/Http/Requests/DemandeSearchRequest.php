<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DemandeSearchRequest extends Request{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'dateEventMin' => 'required_without_all:dateEventMax,dateCreationMin,dateCreationMax',
            'dateEventMax' => 'required_without_all:dateEventMin,dateCreationMin,dateCreationMax',
            'dateCreationMin' => 'required_without_all:dateEventMin,dateEventMax,dateCreationMax',
            'dateCreationMax' => 'required_without_all:dateEventMin,dateEventMax,dateCreationMin'
        ];
    }
}

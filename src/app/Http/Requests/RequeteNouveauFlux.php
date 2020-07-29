<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteNouveauFlux extends FormRequest
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
            'societe' => 'required',
            'type' => 'required',
            'type_contact' => ['required','regex:/^MAIL|APPEL|SMS$/'],
            'contact' => ['required','regex:/^((0|\+33)[1-9]([-. ]?[0-9]{2}){4})|([^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)*\.[a-zA-Z]{2,4})$/'],
            'poids_moyen_benne' => 'nullable|integer',
            'horaires_commande_matin' =>  'nullable',
            'horaires_commande_matin' =>  'nullable',
            'categorie' => 'required',
            
        ];
	 
    }
}

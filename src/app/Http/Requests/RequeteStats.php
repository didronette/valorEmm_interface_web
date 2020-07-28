<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteStats extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $dechetteries = [];
        $fluxx = [];
        
        foreach ($this->request->all() as $key => $value) {
            $tab = explode(":", $key);
            if ($tab[0] == 'flux') {
                array_push($fluxx,$tab[1]);
            }
            else if ($tab[0] == 'dechetterie') {
                array_push($dechetteries,$tab[1]);
            }
        }
        $this->request->add(['dechetteries' => $dechetteries]);
        $this->request->add(['fluxx' => $fluxx]);
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
            'date_debut' => 'required',// Vérifier que les dates sont des dates ?''
            'date_fin' => 'required',
        ];
    }
}

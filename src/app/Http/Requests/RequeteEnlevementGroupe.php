<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteEnlevementGroupe extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->request->add(['date_enlevement' =>   $this->all()['date_date_enlevement'] . " " . $this->all()['heure_date_enlevement'] ]);


        $commandes_rappelees = [];
        
        foreach ($this->request->all() as $key => $value) {
            if (($key != 'date_date_enlevement') &&($key != 'heure_date_enlevement') && ($key != 'nc') && ($key != 'date_enlevement') && ($key != '_token'))  {
                array_push($commandes_rappelees,$value);
            }
        }
        $this->request->add(['commandes_rappelees' => $commandes_rappelees]);
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
            'date_date_enlevement' => 'required',
            'heure_date_enlevement' => 'required',
        ];
    }
}

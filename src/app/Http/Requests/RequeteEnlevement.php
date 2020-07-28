<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon;

class RequeteEnlevement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->request->add(['date_enlevement' =>   $this->all()['date_date_enlevement'] . " " . $this->all()['heure_date_enlevement'] ]);

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
            //Mettre une validation sur les champs pour tard...
        ];
    }
}

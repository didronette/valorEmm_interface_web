<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteNouvelleDechetterie extends FormRequest
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
            'nom' => 'required|alpha',
			'adresse_mac' => ['required','regex:/^[a-fA-F0-9\-]{17}|[a-fA-F0-9]{12}$/'],
        ];
    }
}

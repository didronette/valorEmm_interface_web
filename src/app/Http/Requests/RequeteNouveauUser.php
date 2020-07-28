<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteNouveauUser extends FormRequest
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
            'name' => 'required|alpha|unique:users',
            'email' => 'required|email',
            'password' => 'required',
            'type' => ['required','regex:/^Administrateur|Gérant|Agent|Agglomération$/'],

        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequetePhoto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!(isset(($this->request->all()['name'])))) {
            $this->request->add(['name' => time()]);
        }
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
            'name' => 'alpha_num|nullable|max:150',
            'photo' => 'required|file|mimes:jpeg,png',     
        ];
    }
}

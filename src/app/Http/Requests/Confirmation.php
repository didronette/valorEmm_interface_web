<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class Confirmation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (session()->has('dechetterie')) {
            $users = User::where('type','=','Agent')->get();
            var_dump($users);
            var_dump($this->all()['pin']);
            foreach ($users as $user) {
                
                if (Hash::check($this->all()['pin'], $user->password)) {
                    $this->request->add(['compte' => $user->id]);
                    $this->request->add(['troll' => $user->mamn]);
                    return true;
                }
            }
            
            return true;
        }
        $this->request->add(['compte' => auth()->user()->id]);
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
            'pin' => 'nullable|regex:/[0-9]{4}/'
        ];
    }
}

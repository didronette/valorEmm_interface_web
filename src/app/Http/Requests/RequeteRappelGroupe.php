<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequeteRappelGroupe extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $commandes_rappelees = [];
        
        foreach ($this->request->all() as $key => $value) {
            if (($key != 'pin') && ($key != '_token')) {
                array_push($commandes_rappelees,$value);
            }
            
        
        }
        var_dump($commandes_rappelees);
        $this->request->add(['commandes_rappelees' => $commandes_rappelees]);
        
        if (session()->has('dechetterie')) {
            $users = User::where('type','=','Agent')->get();
            foreach ($users as $user) {
                
                if (Hash::check($this->all()['pin'], $user->password)) {
                    $this->request->add(['compte' => $user->id]);
                    return true;
                }
            }
            
            return false;
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
            //
        ];
    }
}

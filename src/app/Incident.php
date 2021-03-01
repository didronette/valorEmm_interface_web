<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $table = 'Incident';

    public function getPhotos() 
	{	
		return PhotosIncident::where('incident','=', $id)->get();
    }

           /**
     * Renvoie l'objet Dechetterie correspondant à la déchetterie associée à la commande
     */

    public function getDechetterie() 
	{
		return Dechetterie::find($this->dechetterie);
    }
    
       /**
     * Renvoie l'objet Flux correspondant au flux associé à la commande
     */

    public function getAgent() 
	{
		return User::find($this->agent);
	}
}

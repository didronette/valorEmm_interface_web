<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotosIncident extends Model
{
    protected $table = 'PhotosIncident';
    
    public $timestamps = false;

       /**
     * Renvoie l'objet User correspondant à l'utilisateur associé à la commande
     */

    public function getIncident() 
	{	
		return Incident::find($this->incident);
    }
}

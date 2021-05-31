<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoIncident extends Model
{
    protected $table = 'PhotoIncident';
    
    public $timestamps = false;

       /**
     * Renvoie l'objet User correspondant à l'utilisateur associé à la commande
     */

    public function getIncident() 
	{	
		return Incident::find($this->incident);
    }
}

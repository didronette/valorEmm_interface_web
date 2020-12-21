<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $table = 'Commande';


       /**
     * Renvoie l'objet User correspondant à l'utilisateur associé à la commande
     */

    public function getUser() 
	{
		
		return User::find($this->compte);
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

    public function getFlux() 
	{
		return Flux::find($this->flux);
	}

	public function newFromStd(StdClass $std)
    {
        $instance = new static;

        foreach ( (array) $std as $attribute => $value)
        {
            if ( $this->fillableIsSetAndContainsAttribute($attribute) or $this->fillableNotSet())
                $instance->{$attribute} = $value;
        }

        return $instance;
	}
	
	protected function fillableIsSetAndContainsAttribute($attribute)
    {
        return (isset($this->fillable) && count($this->fillable) > 0 && in_array($attribute, $this->fillable));
    }

    /**
     * Returns whether fillable attribute is not set.
     * 
     * @return bool
     */
    protected static function fillableNotSet()
    {
        return ! isset($this->fillable);
    }
}

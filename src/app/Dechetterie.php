<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dechetterie extends Model
{
    protected $table = 'Dechetterie';
    
    public $timestamps = false;

    public function commandes() 
    {
        return $this->hasMany('App\Commande');
    }
}

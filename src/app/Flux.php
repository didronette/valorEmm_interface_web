<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Flux extends Model
{
    use Notifiable;

    protected $table = 'Flux';
    
    public $timestamps = false;

}

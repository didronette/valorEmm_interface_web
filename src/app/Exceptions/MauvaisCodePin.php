<?php

namespace App\Exceptions;

use Exception;

class MauvaisCodePin extends Exception
{
    protected $message;

    public function back($message) {
        $this->route = $route;
        
        return $this;
    }
    
    public function message() {
        return $this->message;
    }
}

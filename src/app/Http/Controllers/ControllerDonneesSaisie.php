<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories;

use App\Flux;
use App\Dechetterie;
use App\Commande;

class ControllerDonneesSaisie extends Controller
{
    // Fonction qui renvoie la liste des flux
    public static function flux($categorie)
	{
        $fluxx =  Flux::all()->groupBy('societe') -> where('categorie', $categorie)->get();
        $retour = array();
        foreach ($fluxx as $flux) {
            $retour[$flux->id] = $flux->type . '(' . $flux->societe . ')';
        }
        return $retour;
    }

    public static function dechetteries()
	{
        
        if (session()->has('dechetterie')) {
            $dechetteries = array(Dechetterie::find(session()->get('dechetterie')));
        }
        else {
            $dechetteries = Dechetterie::all();
        }

        $retour = array();
        foreach ($dechetteries as $dechetterie) {
            $retour[$dechetterie->id] = $dechetterie->nom;
        }
        return $retour;
        
    }

    public static function commandes()
	{
        if (session()->has('dechetterie')) {
            return Commande::where('dechetterie', '=', $dechetterie);
        }
        else {
            return Commande::all();
        }
    } 

    public static function contacts()
	{
        $contacts = DB::table('Flux')->select('societe', 'contact')->distinct()->get();
        return $contacts;
    }
}
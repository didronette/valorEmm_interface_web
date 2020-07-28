<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commande;
use Carbon;

class ControllerDonneesStats extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Commande $commande
     * @return \Illuminate\Http\Response
     */
    public static function calculerDateEnlevementMax(Commande $commande)
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $commande->contact_at);                
        $date->addHours($commande->getFlux()->delai_enlevement);//Date du mail + delai enlevement
        return $date->format('Y-m-d H:i:s');
    } 


}

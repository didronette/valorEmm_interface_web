<?php

namespace App\Http\Controllers;

use App\Commande;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

use Carbon;

class ControllerDonneesStatistiques extends Controller
{

    public static function pourcentageEnlevementATemps($date_debut,$date_fin,$fluxx,$dechetteries) {
        //Sur les commandes enlevées, combien sont enlevees avant la date butoire ? ramené au nb total
        $date_fin = Carbon::createFromFormat('Y-m-d', $date_fin)->addDay()->format('Y-m-d');
        
        if ($fluxx instanceof \Illuminate\Support\Collection) {
            $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->get();
        }
        else {
            $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->whereRaw(self::whereFlux($fluxx))
            ->whereRaw(self::whereDechetteries($dechetteries))
            ->get();
        }


        $defaults = 0;
        foreach ($commandes as $commande) {
            $date_enlevement_max = self::calculerDateEnlevementMax($commande);
            if(Carbon::createFromFormat('Y-m-d H:i:s', $commande->date_enlevement)->gt($date_enlevement_max)) {
                $defaults++;
            }
        }
        if($commandes->count() == 0) {
            return 0;
        }

        return $defaults*100/$commandes->count();
    }

    public static function TonnageEstime($date_debut,$date_fin,$fluxx,$dechetteries) {
        $date_fin = Carbon::createFromFormat('Y-m-d', $date_fin)->addDay()->format('Y-m-d');
        
        if ($fluxx instanceof \Illuminate\Support\Collection) {
            $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->get();
        }
        else {
            $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->whereRaw(self::whereFlux($fluxx))
            ->whereRaw(self::whereDechetteries($dechetteries))
            ->get();
        }


        $tonnage = 0;
        foreach ($commandes as $commande) {
            if (isset($commande->getFlux()->poids_moyen_benne)) {
                $poids = $commande->getFlux()->poids_moyen_benne;
            }
            else {
                $poids = 0;
            }
            $tonnage = $tonnage + $poids*$commande->multiplicite;
        }


        return $tonnage;
    }

    public static function pourcentageNc($date_debut,$date_fin,$fluxx,$dechetteries) {
        $date_fin = Carbon::createFromFormat('Y-m-d', $date_fin)->addDay()->format('Y-m-d');
        
        if ($fluxx instanceof \Illuminate\Support\Collection) {
            $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->get();
        }
        else {
            $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->whereRaw(self::whereFlux($fluxx))
            ->whereRaw(self::whereDechetteries($dechetteries))
            ->get();
        }


        $defaults = 0;
        foreach ($commandes as $commande) {
            $date_enlevement_max = self::calculerDateEnlevementMax($commande);
            if(isset($commande->nc) || isset($commande->ncagglo)) {
                $defaults++;
            }
        }

        if($commandes->count() == 0) {
            return 0;
        }
        return $defaults*100/$commandes->count();    
    }


    public static function donneesGraphe($date_debut,$date_fin,$fluxx,$dechetteries) {
        $date_fin = Carbon::createFromFormat('Y-m-d', $date_fin)->addDay()->format('Y-m-d');
        return $retour =  Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [$date_debut, $date_fin])
            ->whereRaw(self::whereFlux($fluxx))
            ->whereRaw(self::whereDechetteries($dechetteries))
            ->get();

    }

    public static function donneesGrapheNonEnlevee($date_debut,$date_fin,$fluxx,$dechetteries) {
        $date_fin = Carbon::createFromFormat('Y-m-d', $date_fin)->addDay()->format('Y-m-d');
        $commandes =  Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '!=', 'Enlevée')
            ->whereBetween('contact_at', [$date_debut, $date_fin])
            ->whereRaw(self::whereFlux($fluxx))
            ->whereRaw(self::whereDechetteries($dechetteries))
            ->get();
            
        $retour = [];
        foreach ($commandes as $key => $commande) {
            $date_enlevement_max = Carbon::createFromFormat('Y-m-d H:i:s',self::calculerDateEnlevementMax($commande));
            if (Carbon::now()->gt($date_enlevement_max)) {
                array_push( $retour,$commande);
            }
        }

        return $retour;
    }


    public static function donneesCompletesGraphes() {
        $date_fin = Carbon::now()->addDay()->format('Y-m-d');
        return Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'Enlevée')
            ->whereBetween('date_enlevement', [\Illuminate\Support\Facades\Config::get('stats.date_debut_analyse'), $date_fin])
            ->get();        
    }

    public static function donneesCompletesGraphesNonEnlevee() {
        $date_fin = Carbon::now()->addDay()->format('Y-m-d');
        $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '!=', 'Enlevée')
            ->whereBetween('contact_at', [\Illuminate\Support\Facades\Config::get('stats.date_debut_analyse'), $date_fin])
            ->get(); 
        $retour = [];
        foreach ($commandes as $key => $commande) {
            $date_enlevement_max = Carbon::createFromFormat('Y-m-d H:i:s',self::calculerDateEnlevementMax($commande));
            if ($date_enlevement_max->isPast()) {
                array_push( $retour,$commande);
            }
        }
    
        return $retour;
    }

    public static function whereFlux($fluxx) {
        if (count($fluxx) == 0) {
            return 'false';
        }
        $retour = '';
        foreach ($fluxx as $key => $flux) {
            if ($key== array_key_first($fluxx)) {
                $retour = '(flux = '.$flux;
            }
            else {
                $retour = $retour . ' OR flux = '.$flux;
            }
        }
        return $retour.')';
    }   
    
    public static function whereDechetteries($dechetteries) {
        if (count($dechetteries) == 0) {
            return 'false';
        }
        $retour = '';
        foreach ($dechetteries as $key => $dechetterie) {
            if ($key== array_key_first($dechetteries)) {
                $retour = '(dechetterie = '.$dechetterie;
            }
            else {
                $retour = $retour . ' OR dechetterie = '.$dechetterie;
            }
        }
        return $retour.')';
    }

    public static function getDates($date_debut,$date_fin) {
        $retour = [];

        $date = Carbon::createFromFormat('Y-m-d', $date_debut);
        $date_fin = Carbon::createFromFormat('Y-m-d', $date_fin);
        $date_fin->addDay();
        while ($date_fin->gt($date)) {
            array_push($retour,$date->format('Y-m-d'));
            $date->addDay();
        }

        return $retour;
    }
            
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

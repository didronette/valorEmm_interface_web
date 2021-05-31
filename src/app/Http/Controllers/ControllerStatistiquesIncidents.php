<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteStats;
use App\Http\Requests\RequeteRapport;

use App\Dechetterie;
use App\Incident;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ControllerDonneesStatistiques;

use PDF;
use Dompdf\Dompdf;

class ControllerStatistiquesIncidents extends Controller
{
    public function getDonneesIncident($date_debut,$date_fin) {
        $date_fin = \Carbon::createFromFormat('Y-m-d', $date_fin)->addDay()->format('Y-m-d');
        $incidents =  Incident::whereBetween('date_heure', [$date_debut, $date_fin])
            ->get();

      
            
        return Incident::hydrate($incidents->toArray());
    }

 
    public function rapport(RequeteRapport $requete) // Fonction pour l'affichage de l'accueil
	  {
      

      $inputs = $requete->all();

      $donnees = self::getDonneesIncident($inputs['date_debut'],$inputs['date_fin']);
/*
      $enregistrements = [];
      foreach ($donnees  as $donnee) {
        array_push($enregistrements,$this->formuler($donnee));

      }
*/
    

      $pdf  = PDF::loadView('incidents/rapport', ['enregistrements' => $donnees]);
        

     
      $nom_rapport = 'rapport_incidents_'.\Carbon::now()->format('d-m-Y').'.pdf';
		return $pdf->download($nom_rapport);

    }



    public function formuler(Incident $incident) { 
      
      return '';
      
    }


    public static function formulerDate(String $date) {
      $weekMap = [
        0 => 'Dimanche',
        1 => 'Lundi',
        2 => 'Mardi',
        3 => 'Mercredi',
        4 => 'Jeudi',
        5 => 'Vendredi',
        6 => 'Samedi',
    ];
    
      $date_carboned = \Carbon::createFromFormat('Y-m-d H:i:s', $date);
      $dayOfTheWeek = $date_carboned->dayOfWeek;
      $weekday = $weekMap[$dayOfTheWeek];
      return $weekday. ' ' . $date_carboned->format('d-m-Y'). ' à '. $date_carboned->format('H:i:s').' ';
    }

    public static function calculeTempsDepuisCreation($commande) {
      \Carbon::setLocale('fr');
      $date = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->created_at);
      $date_debut = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->contact_at);
      $retour = $date_debut->diffForHumans($date, 1, true, 2).' ';
      return $retour;
    }

    public static function calculeTempsDepuisCreationEnlevement($commande) {
      \Carbon::setLocale('fr');
      $date = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->date_enlevement);
      $date_debut = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->contact_at);
      $retour = $date_debut->diffForHumans($date, 1, true, 2).' ';
      return $retour;
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteStats;
use App\Http\Requests\RequeteRapport;
use Illuminate\Http\Request;

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
            ->orderBy('date_heure', 'ASC')
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

    public function exportCsv(Request $requete)
    {
      $inputs = $requete->all();
      $donnees = self::getDonneesIncident($inputs['date_debut'],$inputs['date_fin']);
       $fileName = 'incidents_'.$inputs['date_debut'].'_'.$inputs['date_fin'].'.csv';
       
    
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
    
            $columns = array('Numéro d\'incident', 'Catégorie', 'Agent', 'Déchetterie', 'Date et heure','Numéro SIDEM PASS','Immatriculation du véhicule','Type du véhicule','Marque du véhicule','Couleur du véhicule','Description','Réponse apportée','Photos associées');
    
            $callback = function() use($donnees, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                foreach ($donnees as $incident) {
                    $row['Numéro d\'incident']  =  $incident->id;
                    $row['Catégorie']  =  $incident->categorie;
                    $row['Agent']  =  $incident->getAgent()->name;
                    $row['Déchetterie']  =  $incident->getDechetterie()->nom;
                    $row['Date et heure']  =  $incident->date_heure;
                    $row['Numéro SIDEM PASS']  =  $incident->numero_sidem_pass;
                    $row['Immatriculation du véhicule']  =  $incident->immatriculation_vehicule;
                    $row['Type du véhicule']  =  $incident->type_vehicule;
                    $row['Marque du véhicule']  =  $incident->marque_vehicule;
                    $row['Couleur du véhicule']  =  $incident->couleur_vehicule;
                    $row['Description']  =  $incident->description;
                    $row['Réponse apportée']  =  $incident->reponse_apportee;
                    
                    $photos = $incident->getPhotos();
                    $liste_photos = '|';
                    foreach ($photos as $photo) {
                      $liste_photos = $liste_photos.$photo->url.'|';
                    }
                    
                    $row['Photos associées']  =  $liste_photos;
                    

                    fputcsv($file, array($row['Numéro d\'incident'], $row['Catégorie'], $row['Agent'], $row['Déchetterie'], $row['Date et heure'], $row['Numéro SIDEM PASS'], $row['Immatriculation du véhicule'], $row['Type du véhicule'], $row['Marque du véhicule'], $row['Couleur du véhicule'], $row['Description'], $row['Réponse apportée'], $row['Photos associées']));
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
    }
    
}

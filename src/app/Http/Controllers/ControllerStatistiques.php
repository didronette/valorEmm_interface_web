<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteStats;
use App\Http\Requests\RequeteRapport;

use App\Dechetterie;
use App\Flux;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ControllerDonneesStatistiques;

use mikehaertl\wkhtmlto\Pdf;

class ControllerStatistiques extends Controller
{
    public function vueStatistiques() // Fonction pour l'affichage de l'accueil
	{
      $fluxx = Flux::all();
      $dechetteries = Dechetterie::all();

      $donnees = ControllerDonneesStatistiques::donneesCompletesGraphes();

      $donnees_nonEnlevee = ControllerDonneesStatistiques::donneesCompletesGraphesNonEnlevee();

      $dates = ControllerDonneesStatistiques::getDates(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'));

      $donnees_pas_enlevee = [];
      $donnees_nc = [];
      $donnees_nc_agglo = [];
      $donnees_retard_enlevement = [];
      $donnees_ok = [];
      

      foreach ($dates as $date) {
        array_push($donnees_pas_enlevee,0);
        array_push($donnees_nc,0);
        array_push($donnees_nc_agglo,0);
        array_push($donnees_retard_enlevement,0);
        array_push($donnees_ok,0);
        
      }
      
      foreach ($donnees_nonEnlevee as $commande) {
        $date = \Carbon::createFromFormat('Y-m-d H:i:s',$commande->contact_at);
        $indice = array_search($date->format('Y-m-d'),$dates);
        $donnees_pas_enlevee[$indice]++;
      }

      

      foreach ($donnees as $commande) {
        $date_enlevement = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->date_enlevement);
        $indice = array_search($date_enlevement->format('Y-m-d'),$dates);
        $date_enlevement_max = \Carbon::createFromFormat('Y-m-d H:i:s',ControllerDonneesStatistiques::calculerDateEnlevementMax($commande));
        if ($date_enlevement->gt($date_enlevement_max)) {
          $donnees_retard_enlevement[$indice]++;
        }
        else if (isset($commande->nc)) {
          $donnees_nc[$indice]++;
        }
        else if (isset($commande->ncagglo)) {
          $donnees_nc_agglo[$indice]++;
        }
        else {
          $donnees_ok[$indice]++;
        }
      }
     $pourcentage_enlevement_dans_les_delais = ControllerDonneesStatistiques::pourcentageEnlevementATemps(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $tonnes = ControllerDonneesStatistiques::TonnageEstime(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $pourcentage_nc = ControllerDonneesStatistiques::pourcentageNc(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);

      return view('statistiques/accueil_default', ['pourcentage_enlevement_dans_les_delais' => $pourcentage_enlevement_dans_les_delais,'tonnes' => $tonnes,'pourcentage_nc' => $pourcentage_nc,'fluxx' => $fluxx, 'dechetteries' => $dechetteries, 'donnees_nc' => $donnees_nc, 'donnees_nc_agglo' => $donnees_nc_agglo, 'donnees_retard_enlevement' => $donnees_retard_enlevement, 'donnees_ok' => $donnees_ok, 'dates' => $dates,'donnees_pas_enlevee' => $donnees_pas_enlevee]);
    }

    public function vueNC() // Fonction pour l'affichage de l'accueil
	{
		return view('statistiques/nc');
    }



    public function updateVueStatistiques(RequeteStats $requete) // Fonction pour l'affichage de l'accueil
	  {
      $fluxx = Flux::all();
      $dechetteries = Dechetterie::all();

      $inputs = $requete->all();
      $donnees = ControllerDonneesStatistiques::donneesGraphe($inputs['date_debut'],$inputs['date_fin'],$inputs['fluxx'],$inputs['dechetteries']);
      $donnees_nonEnlevee = ControllerDonneesStatistiques::donneesGrapheNonEnlevee($inputs['date_debut'],$inputs['date_fin'],$inputs['fluxx'],$inputs['dechetteries']);
      $dates = ControllerDonneesStatistiques::getDates($inputs['date_debut'],$inputs['date_fin']);
      
      $donnees_pas_enlevee = [];
      $donnees_nc = [];
      $donnees_nc_agglo = [];
      $donnees_retard_enlevement = [];
      $donnees_ok = [];

      foreach ($dates as $date) {
        array_push($donnees_pas_enlevee,0);
        array_push($donnees_nc,0);
        array_push($donnees_nc_agglo,0);
        array_push($donnees_retard_enlevement,0);
        array_push($donnees_ok,0);
      }

      foreach ($donnees_nonEnlevee as $commande) {
        $date_enlevement_max = \Carbon::createFromFormat('Y-m-d H:i:s',ControllerDonneesStatistiques::calculerDateEnlevementMax($commande));
        $indice = array_search($date_enlevement_max->format('Y-m-d'),$dates);
        $donnees_pas_enlevee[$indice]++;
      }

      foreach ($donnees as $commande) {
        $date_enlevement = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->date_enlevement);
        $indice = array_search($date_enlevement->format('Y-m-d'),$dates);
        $date_enlevement_max = \Carbon::createFromFormat('Y-m-d H:i:s',ControllerDonneesStatistiques::calculerDateEnlevementMax($commande));
        if (($date_enlevement->gt($date_enlevement_max)) && isset($inputs['enlevement'])) {
          $donnees_retard_enlevement[$indice]++;
        }
        else if ((isset($commande->nc)) && isset($inputs['nc'])) {
          $donnees_nc[$indice]++;
        }
        else if ((isset($commande->ncagglo)) && isset($inputs['ncagglo'])) {
          $donnees_nc_agglo[$indice]++;
        }
        else {
          $donnees_ok[$indice]++;
        }
      }

      $pourcentage_enlevement_dans_les_delais = ControllerDonneesStatistiques::pourcentageEnlevementATemps(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $tonnes = ControllerDonneesStatistiques::TonnageEstime(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $pourcentage_nc = ControllerDonneesStatistiques::pourcentageNc(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);

      return view('statistiques/accueil_updated', ['pourcentage_enlevement_dans_les_delais' => $pourcentage_enlevement_dans_les_delais,'tonnes' => $tonnes,'pourcentage_nc' => $pourcentage_nc,'fluxx' => $fluxx, 'dechetteries' => $dechetteries, 'donnees_nc' => $donnees_nc, 'donnees_nc_agglo' => $donnees_nc_agglo, 'donnees_retard_enlevement' => $donnees_retard_enlevement, 'donnees_ok' => $donnees_ok, 'dates' => $dates,'enlevement' => isset($inputs['enlevement']),'tonnage' => isset($inputs['tonnage']),'nc' => isset($inputs['nc']),'ncagglo' => isset($inputs['ncagglo']),'donnees_pas_enlevee' => $donnees_pas_enlevee]);

    }
 
    public function genererRapport(RequeteRapport $requete) // Fonction pour l'affichage de l'accueil
	  {
      $fluxx = Flux::all();
      $dechetteries = Dechetterie::all();

      $inputs = $requete->all();
      $donnees = ControllerDonneesStatistiques::donneesGraphe($inputs['date_debut'],$inputs['date_fin'],$inputs['fluxx'],$inputs['dechetteries']);
      $donnees_nonEnlevee = ControllerDonneesStatistiques::donneesGrapheNonEnlevee($inputs['date_debut'],$inputs['date_fin'],$inputs['fluxx'],$inputs['dechetteries']);
      $dates = ControllerDonneesStatistiques::getDates($inputs['date_debut'],$inputs['date_fin']);
      
      $donnees_pas_enlevee = [];
      $donnees_nc = [];
      $donnees_nc_agglo = [];
      $donnees_retard_enlevement = [];
      $donnees_ok = [];

      foreach ($dates as $date) {
        array_push($donnees_pas_enlevee,0);
        array_push($donnees_nc,0);
        array_push($donnees_nc_agglo,0);
        array_push($donnees_retard_enlevement,0);
        array_push($donnees_ok,0);
      }

      foreach ($donnees_nonEnlevee as $commande) {
        $date_enlevement_max = \Carbon::createFromFormat('Y-m-d H:i:s',ControllerDonneesStatistiques::calculerDateEnlevementMax($commande));
        $indice = array_search($date_enlevement_max->format('Y-m-d'),$dates);
        $donnees_pas_enlevee[$indice]++;
      }

      foreach ($donnees as $commande) {
        $date_enlevement = \Carbon::createFromFormat('Y-m-d H:i:s', $commande->date_enlevement);
        $indice = array_search($date_enlevement->format('Y-m-d'),$dates);
        $date_enlevement_max = \Carbon::createFromFormat('Y-m-d H:i:s',ControllerDonneesStatistiques::calculerDateEnlevementMax($commande));
        if (($date_enlevement->gt($date_enlevement_max)) && isset($inputs['enlevement'])) {
          $donnees_retard_enlevement[$indice]++;
        }
        else if ((isset($commande->nc)) && isset($inputs['nc'])) {
          $donnees_nc[$indice]++;
        }
        else if ((isset($commande->ncagglo)) && isset($inputs['ncagglo'])) {
          $donnees_nc_agglo[$indice]++;
        }
        else {
          $donnees_ok[$indice]++;
        }
      }

      $pourcentage_enlevement_dans_les_delais = ControllerDonneesStatistiques::pourcentageEnlevementATemps(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $tonnes = ControllerDonneesStatistiques::TonnageEstime(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $pourcentage_nc = ControllerDonneesStatistiques::pourcentageNc(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);

      $render  = view('rapport', ['pourcentage_enlevement_dans_les_delais' => $pourcentage_enlevement_dans_les_delais,'tonnes' => $tonnes,'pourcentage_nc' => $pourcentage_nc,'fluxx' => $fluxx, 'dechetteries' => $dechetteries, 'donnees_nc' => $donnees_nc, 'donnees_nc_agglo' => $donnees_nc_agglo, 'donnees_retard_enlevement' => $donnees_retard_enlevement, 'donnees_ok' => $donnees_ok, 'dates' => $dates,'enlevement' => isset($inputs['enlevement']),'tonnage' => isset($inputs['tonnage']),'nc' => isset($inputs['nc']),'ncagglo' => isset($inputs['ncagglo']),'donnees_pas_enlevee' => $donnees_pas_enlevee])->render();
        
    return $render;

      $pdf = new Pdf;

      $pdf->addPage($render);

      $pdf->setOptions(['javascript-delay' => 5000]);
      

      if (!$pdf->saveAs(public_path('report.pdf'))) {
        return $pdf->getError();
    }

      return response()->download(public_path('report.pdf'));
    }    

}

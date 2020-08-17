<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteStats;
use App\Http\Requests\RequeteRapport;

use App\Dechetterie;
use App\Flux;
use App\Commande;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\ControllerDonneesStatistiques;

use PDF;
use Dompdf\Dompdf;

class ControllerStatistiques extends Controller
{
    public function vueStatistiques() // Fonction pour l'affichage de l'accueil
	{
      $fluxx = Flux::all();
      $dechetteries = Dechetterie::all();

      $donnees = ControllerDonneesStatistiques::donneesCompletesGraphes();

      $donnees_nonEnlevee = ControllerDonneesStatistiques::donneesCompletesGraphesNonEnlevee();

      $dates = ControllerDonneesStatistiques::getDates(\Carbon::now()->subMonth()->format('Y-m-d'),\Carbon::now()->format('Y-m-d'));

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
     $pourcentage_enlevement_dans_les_delais = ControllerDonneesStatistiques::pourcentageEnlevementATemps(Config::get(\Carbon::now()->subMonth()->format('Y-m-d')),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $tonnes = ControllerDonneesStatistiques::TonnageEstime(Config::get(\Carbon::now()->subMonth()->format('Y-m-d')),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);
      $pourcentage_nc = ControllerDonneesStatistiques::pourcentageNc(Config::get(\Carbon::now()->subMonth()->format('Y-m-d')),\Carbon::now()->format('Y-m-d'),$fluxx,$dechetteries);

      return view('statistiques/accueil_default', ['pourcentage_enlevement_dans_les_delais' => $pourcentage_enlevement_dans_les_delais,'tonnes' => $tonnes,'pourcentage_nc' => $pourcentage_nc,'fluxx' => $fluxx, 'dechetteries' => $dechetteries, 'donnees_nc' => $donnees_nc, 'donnees_nc_agglo' => $donnees_nc_agglo, 'donnees_retard_enlevement' => $donnees_retard_enlevement, 'donnees_ok' => $donnees_ok, 'dates' => $dates,'donnees_pas_enlevee' => $donnees_pas_enlevee]);
    }

    public function vueNC() // Fonction pour l'affichage de l'accueil
	{
		return view('statistiques/nc');
    }



    public function updateVueStatistiques(RequeteStats $requete) // Fonction pour l'affichage de l'accueil
	  {
      

      $inputs = $requete->all();

      $dechetteries = Dechetterie::all();

      foreach ($dechetteries as $key => $dechetterie) {
        if (!(in_array($dechetterie->id,$inputs['dechetteries']))) {
          $dechetteries->forget($key);
        }
      }
      $fluxx = Flux::all();

      foreach ($fluxx as $key => $flux) {
        if (!(in_array($flux->id,$inputs['fluxx']))) {
          $fluxx->forget($key);
        }
      }


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

      $pourcentage_enlevement_dans_les_delais = ControllerDonneesStatistiques::pourcentageEnlevementATemps(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$inputs['fluxx'],$inputs['dechetteries']);
      $tonnes = ControllerDonneesStatistiques::TonnageEstime(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$inputs['fluxx'],$inputs['dechetteries']);
      $pourcentage_nc = ControllerDonneesStatistiques::pourcentageNc(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$inputs['fluxx'],$inputs['dechetteries']);


      $dechetteries = Dechetterie::all();

      $fluxx = Flux::all();

      return view('statistiques/accueil_updated', ['pourcentage_enlevement_dans_les_delais' => $pourcentage_enlevement_dans_les_delais,'tonnes' => $tonnes,'pourcentage_nc' => $pourcentage_nc,'fluxx' => $fluxx, 'dechetteries' => $dechetteries, 'donnees_nc' => $donnees_nc, 'donnees_nc_agglo' => $donnees_nc_agglo, 'donnees_retard_enlevement' => $donnees_retard_enlevement, 'donnees_ok' => $donnees_ok, 'dates' => $dates,'enlevement' => isset($inputs['enlevement']),'tonnage' => isset($inputs['tonnage']),'nc' => isset($inputs['nc']),'ncagglo' => isset($inputs['ncagglo']),'donnees_pas_enlevee' => $donnees_pas_enlevee]);

    }
 
    public function genererRapport(RequeteRapport $requete) // Fonction pour l'affichage de l'accueil
	  {
      

      $inputs = $requete->all();

      $dechetteries = Dechetterie::all();

      foreach ($dechetteries as $key => $dechetterie) {
        if (!(in_array($dechetterie->id,$inputs['dechetteries']))) {
          $dechetteries->forget($key);
        }
      }
      $fluxx = Flux::all();

      foreach ($fluxx as $key => $flux) {
        if (!(in_array($flux->id,$inputs['fluxx']))) {
          $fluxx->forget($key);
        }
      }

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

      $pourcentage_enlevement_dans_les_delais = ControllerDonneesStatistiques::pourcentageEnlevementATemps(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$inputs['fluxx'],$inputs['dechetteries']);
      $tonnes = ControllerDonneesStatistiques::TonnageEstime(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$inputs['fluxx'],$inputs['dechetteries']);
      $pourcentage_nc = ControllerDonneesStatistiques::pourcentageNc(Config::get('stats.date_debut_analyse'),\Carbon::now()->format('Y-m-d'),$inputs['fluxx'],$inputs['dechetteries']);

      $commandes = Commande::all();

      $enregistrements = [];

      foreach ($commandes as $commande) {
        if (in_array($commande->flux,$inputs['fluxx']) && in_array($commande->dechetterie,$inputs['dechetteries'])) {
          array_push($enregistrements,$this->formuler($commande,isset($inputs['ncagglo']),isset($inputs['nc']),isset($inputs['enlevement'])));

        }
      }

      $pdf  = PDF::loadView('statistiques/rapport', ['pourcentage_enlevement_dans_les_delais' => $pourcentage_enlevement_dans_les_delais,'tonnes' => $tonnes,'pourcentage_nc' => $pourcentage_nc,'fluxx' => $fluxx, 'dechetteries' => $dechetteries, 'donnees_nc' => $donnees_nc, 'donnees_nc_agglo' => $donnees_nc_agglo, 'donnees_retard_enlevement' => $donnees_retard_enlevement, 'donnees_ok' => $donnees_ok, 'dates' => $dates,'enlevement' => isset($inputs['enlevement']),'tonnage' => isset($inputs['tonnage']),'nc' => isset($inputs['nc']),'ncagglo' => isset($inputs['ncagglo']),'donnees_pas_enlevee' => $donnees_pas_enlevee,'graphe' => $inputs['graphe'],'enregistrements' => $enregistrements,'logs' => isset($inputs['logs']),'graphique' => isset($inputs['graphique'])]);
        

     

		return $pdf->download('rapport.pdf');

    }

    public function formuler(Commande $commande,$ncagglo,$nc,$enlevement) { // TODO : fonction à terminer
      $flux = $commande->getFlux();
      if (($commande->statut == 'En attente d\'envoie') ||($commande->statut == 'Modifiée')) {
        return $commande->created_at.'     '."\t".$commande->getUser()->name.'        '."\t".$commande->statut.' Commande: '.$commande->numero.'('.$commande->numero_groupe.') '.$flux->type. '('.$flux->societe.') x'.$commande->multiplicite.'         '."\t".$commande->getDechetterie()->nom."\n";
      }
      else if (($commande->statut == 'NC (agglo)') && $ncagglo) {
        return $commande->created_at.' '.$commande->getUser()->name.' '.$commande->statut.' Commande: '.$commande->numero.' ('.$commande->numero_groupe.') '.$commande->ncagglo."\n";
      }
      else if ((($commande->statut == 'Relancée') || ($commande->statut == 'Envoyée') || ($commande->statut == 'Passée') || ($commande->statut == 'Supprimée')) && $commande) {
        return $commande->created_at.' '.$commande->getUser()->name.' '.$commande->statut.' Commande: '.$commande->numero.' ('.$commande->numero_groupe.")\n";
      }
      else if (($commande->statut == 'Enlevée') && ($enlevement || $nc)) {
        return $commande->created_at.' '.$commande->getUser()->name.' '.$commande->statut.' Commande: '.$commande->numero.' ('.$commande->numero_groupe.') '.$commande->date_enlevement.' '.$commande->nc."\n";
      }  

      
      return '';
      
    }

}
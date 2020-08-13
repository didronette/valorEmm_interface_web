<?php

namespace App\Repositories;

use App\Commande;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Contacts;



use Illuminate\Support\Facades\Session;



class CommandeRepository
{

    protected $commande;

	public function __construct(Commande $commande)
	{
		$this->commande = $commande;
	}

	private function save(Commande $commande, Array $inputs)
	{
		$enregistrement = new $this->commande;

		$enregistrement->numero = $commande->numero;
		$enregistrement->statut = $commande->statut;
		$enregistrement->numero_groupe = $commande->numero_groupe;

		if (isset($inputs['multiplicite'])) {
			$enregistrement->multiplicite = $inputs['multiplicite'];
		}
		else {
			$enregistrement->multiplicite = $commande->multiplicite;
		}

		if (isset($inputs['nc'])) {
			$enregistrement->nc = $inputs['nc'];
		}

		if (isset($inputs['date_enlevement'])) {
			$enregistrement->date_enlevement = $inputs['date_enlevement'];
		}

		if (isset($inputs['dechetterie'])) {
			$enregistrement->dechetterie = $inputs['dechetterie'];
		}
		else {
			$enregistrement->dechetterie = $commande->dechetterie;
		}

		if (isset($inputs['flux'])) {
			$enregistrement->flux = $inputs['flux'];
		}
		else {
			$enregistrement->flux = $commande->flux;
		}
		
			
		$enregistrement->compte = $inputs['compte'];
		$enregistrement->contact_at = $commande->contact_at;

		$enregistrement->save();

		if ($enregistrement->statut == 'En attente d\'envoie') {
			$envoie = Carbon::createFromFormat('Y-m-d H:i:s', $commande->contact_at);
			if (abs($envoie->diffInSeconds(Carbon::now()))<60) { // A une minute près on envoie la commande
				Contacts::nouvelleCommande($enregistrement);
			}
		} else if ($enregistrement->statut == 'Relancée') {
			Contacts::rappelCommande($enregistrement);
		} else if ($enregistrement->statut == 'Modifiée') {
			Contacts::modifCommande($enregistrement);
		} else if ($enregistrement->statut == 'Supprimée') {
			Contacts::delCommande($enregistrement);
		}
	}

	public function getPaginate($n)
	{
		

		if (session()->has('dechetterie')) {
			return $requete = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))

            ->where(function ($query) {
				$query->where('statut', '=', 'Passée')
					  ->orWhere('statut', '=', 'Modifiée')
					  ->orWhere('statut', '=', 'En attente d\'envoie')
					  ->orWhere('statut', '=', 'NC (agglo)')
					  ->orWhere('statut', '=', 'Relancée');
			})
					->where('dechetterie', '=', Session::get('dechetterie'))
					->paginate($n);
		}
		else {

			return $requete = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))

            ->where(function ($query) {
				$query->where('statut', '=', 'Passée')
					  ->orWhere('statut', '=', 'Modifiée')
					  ->orWhere('statut', '=', 'En attente d\'envoie')
					  ->orWhere('statut', '=', 'NC (agglo)')
					  ->orWhere('statut', '=', 'Relancée');
			})
			->paginate($n);
			
			
		}
					
	}

	public function getPaginateGr($n)
	{
		if (session()->has('dechetterie')) {
			return $requete = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero_groupe, MAX(id) AS maxDate FROM Commande GROUP BY numero_groupe ) groupeC ON c.numero_groupe = groupeC.numero_groupe AND c.id = groupeC.maxDate) t'))

            ->where(function ($query) {
				$query->where('statut', '=', 'Passée')
					  ->orWhere('statut', '=', 'Modifiée')
					  ->orWhere('statut', '=', 'En attente d\'envoie')
					  ->orWhere('statut', '=', 'NC (agglo)')
					  ->orWhere('statut', '=', 'Relancée');
			})
					->where('dechetterie', '=', Session::get('dechetterie'))
					->paginate($n);
		}
		else {

			return $requete = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero_groupe, MAX(id) AS maxDate FROM Commande GROUP BY numero_groupe ) groupeC ON c.numero_groupe = groupeC.numero_groupe AND c.id = groupeC.maxDate) t'))
            ->where(function ($query) {
				$query->where('statut', '=', 'Passée')
					  ->orWhere('statut', '=', 'Modifiée')
					  ->orWhere('statut', '=', 'En attente d\'envoie')
					  ->orWhere('statut', '=', 'NC (agglo)')
					  ->orWhere('statut', '=', 'Relancée');
			})
			->paginate($n);
			
			
		}
					
	}

	public function store(Array $inputs) {

		$commande = new $this->commande;		

		$commande->flux = $inputs['flux'];
		$commande->statut = 'En attente d\'envoie';

		$commande->numero = Commande::all()->max('numero')+1;
		$commande->numero_groupe = $inputs['numero_groupe'];
		
		$commande->contact_at = $this->calculerDateContact($commande);

		$this->save($commande, $inputs);

		return $commande;
	}

	public function getById($id)
	{
		$commande = Commande::where('numero','=', $id)->orderByDesc('id')->first();
		$respo = Commande::where('numero','=', $id)->where('statut','!=','NC (agglo)')
		->where('statut','!=','Passée')
		->orderByDesc('id')->first()->compte;
		$commande->compte = $respo;
		return $commande;
	}

	public function getByGroupe($idGr)
	{
		if (session()->has('dechetterie')) {
			return $requete = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))

            ->where(function ($query) {
				$query->where('statut', '=', 'Passée')
					  ->orWhere('statut', '=', 'Modifiée')
					  ->orWhere('statut', '=', 'En attente d\'envoie')
					  ->orWhere('statut', '=', 'NC (agglo)')
					  ->orWhere('statut', '=', 'Relancée');
			})
					->where('dechetterie', '=', Session::get('dechetterie'))
					->where('numero_groupe','=',$idGr)
					->get();
		}
		else {

			return $requete = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))

            ->where(function ($query) {
				$query->where('statut', '=', 'Passée')
					  ->orWhere('statut', '=', 'Modifiée')
					  ->orWhere('statut', '=', 'En attente d\'envoie')
					  ->orWhere('statut', '=', 'NC (agglo)')
					  ->orWhere('statut', '=', 'Relancée');
			})
			->where('numero_groupe','=',$idGr)
			->get();
			
			
		}
	}

	public function update(Array $inputs, $nouveauStatut)
	{
		$commande = $this->getById($inputs['numero']);
		
		if ($nouveauStatut == 'Modifiée') {
			$commande->contact_at = $this->calculerDateContact($commande);
			if ($commande->statut=='En attente d\'envoie') {
				$nouveauStatut = $commande->statut;
			}
		} else if ($nouveauStatut == 'Relancée') {
			$commande->contact_at = $this->calculerDateContact($commande);
		}
		$commande->statut = $nouveauStatut;
		$this->save($commande, $inputs);
	}

	public function destroy($id,$compte)
	{
		 
		$commande = $this->getById($id);
		$inputs['dechetterie'] = $commande->dechetterie;
		$inputs['flux'] = $commande->flux;
		$inputs['compte'] = $compte;
		if ($commande->statut == 'En attente d\'envoie') {
			$commande->statut = 'Annulée';
		}
		else {
			$commande->statut = 'Supprimée';
		}
		
		$this->save($commande, $inputs);
	}

	    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Commande $commande
     * @return \Illuminate\Http\Response
     */
    public function calculerDateContact(Commande $commande) // à stocker dans la table vu à quel point le truc est fat
    {
		
        $flux = $commande->getFlux();

        if ((!(isset($flux->horaires_commande_matin))) && (!(isset($flux->horaires_commande_aprem))) && (!(isset($flux->jour_commande))))
        {
            return Carbon::now();
        }
        $date = Carbon::now();
        if (isset($flux->jour_commande)) {
			
            while(!(self::jourMatch($commande, $date))) {
                $date->addDay();
                $date->hour(0);
            }
        }
		
        if ((isset($flux->horaires_commande_matin)) && (isset($flux->horaires_commande_aprem))) {
            $h_matin = $date->copy()->setTimeFromTimeString($flux->horaires_commande_matin);
            $h_aprem = $date->copy()->setTimeFromTimeString($flux->horaires_commande_aprem);

            if ($h_matin > $date) {
                return $h_matin;
            }
            else if ($h_aprem > $date) {
                return $h_aprem;
            }
            else {
				$h_matin->addDay();
				if (isset($flux->jour_commande)) {
					while(!(self::jourMatch($commande, $h_matin))) {
						$h_matin->addDay();
					}
				}
				
                return $h_matin;
            }
        }

        if (isset($flux->horaires_commande_aprem)) {
            $h_aprem = $date->copy()->setTimeFromTimeString($flux->horaires_commande_aprem);
            
            if ($h_aprem > $date) {
                return $h_aprem;
            }
            else {
				$h_aprem->addDay();
                if (isset($flux->jour_commande)) {
					while(!(self::jourMatch($commande, $h_aprem))) {
						$h_aprem->addDay();
					}
				}
                return $h_aprem;
            }
        }

        if (isset($flux->horaires_commande_matin)) {
            $h_aprem = $date->copy()->setTimeFromTimeString($flux->horaires_commande_matin);
            
            if ($h_matin > $date) {
                return $h_matin;
            }
            else {
				$h_matin->addDay();
                if (isset($flux->jour_commande)) {
					while(!(self::jourMatch($commande, $h_matin))) {
						$h_matin->addDay();
					}
				}
				
                return $h_matin;
            }
        }
        
        return $date->setTime(16,0,0);

    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Commande $commande
     * @return \Illuminate\Http\Response
     */
    public function jourMatch(Commande $commande, Carbon $date) // à stocker dans la table vu à quel point le truc est fat
    {
		$jour = strval($date->dayOfWeek);
		var_dump($jour);
        $jours_possibles = explode("-",$commande->getFlux()->jour_commande);
        return in_array($jour,$jours_possibles);

    } 

    public function setNcAgglo(array $inputs) // à stocker dans la table vu à quel point le truc est fat
    {
		$commande = $this->getById($inputs['numero'])->replicate();
		$commande->ncagglo = $inputs['ncagglo'];
		$commande->compte = $inputs['compte'];
		$commande->statut = 'NC (agglo)';
		$commande->save();

    } 


}
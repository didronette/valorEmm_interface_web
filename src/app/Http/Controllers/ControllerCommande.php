<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteNouvelleCommande;
use App\Http\Requests\RequeteModifCommande;
use App\Http\Requests\RequeteEnlevement;

use App\Http\Requests\Confirmation;
use App\Dechetterie;
use App\Flux;
use App\Commande;

use App\Http\Controllers\ControllerDonneesSaisie;
use App\Repositories\CommandeRepository;
use Carbon;

use App\Http\Requests\RequeteNcAgglo;
use App\Http\Requests\RequeteRappelGroupe;
use App\Http\Requests\RequeteEnlevementGroupe;



class ControllerCommande extends Controller
{
    protected $nbrPerPage = 3000;

    protected $commandeRepository;

    public function __construct(CommandeRepository $commandeRepository)
	{
		$this->commandeRepository = $commandeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = $this->commandeRepository->getPaginate($this->nbrPerPage);
        $links = $commandes->render();
        //return compact('commandes', 'links');
        return view('saisie/gestionCommande',compact('commandes', 'links'));
    }
    
/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGroupe()
    {
        $commandes = $this->commandeRepository->getPaginateGr($this->nbrPerPage);
        $links = $commandes->render();
        //return compact('commandes', 'links');
        return view('saisie/gr/gestionCommande',compact('commandes', 'links'));
    }

    public function create()
    {
        session()->forget('commandes');
        return view('saisie/nouvelleCommande/choixCategorie');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBenne()
    {
        session()->put(['route' => 'benne']);
        $fluxx = ControllerDonneesSaisie::flux('Benne');
        $dechetteries = ControllerDonneesSaisie::dechetteries();
        return view('saisie/nouvelleCommande/nouvelleCommandeBenne', compact('dechetteries', 'fluxx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDDS()
    {
        session()->put(['route' => 'dds']);
        $fluxx = ControllerDonneesSaisie::flux('DDS');
        $dechetteries = ControllerDonneesSaisie::dechetteries();
        return view('saisie/nouvelleCommande/nouvelleCommandeDDS', compact('dechetteries', 'fluxx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createAutre()
    {
        session()->put(['route' => 'autres']);
        $fluxx = ControllerDonneesSaisie::flux('Autres déchets');
        $dechetteries = ControllerDonneesSaisie::dechetteries();
        return view('saisie/nouvelleCommande/nouvelleCommandeAutres', compact('dechetteries', 'fluxx'));
    }


    /**
     * Affiche la liste des contacts
     *
     * @return \Illuminate\Http\Response
     */    
    public function listeContacts() {
        $contacts = ControllerDonneesSaisie::contacts();
        return view('saisie/listeContact')->with('contacts', $contacts);;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\RequeteNouvelleCommande  $request
     * @return \Illuminate\Http\Response
     */
    public function stack()
    {
        $inputs = session()->get('inputs');
        //var_dump($inputs);
        if (!(session()->has('commandes'))) {
            session()->put(['commandes' => []]);
        }
        $commandes = session()->get('commandes'); 
        array_push($commandes,$inputs);
        session()->put(['commandes' => $commandes]);
        $flux = Flux::find($inputs['flux']);
        if ($flux->categorie == 'Benne') {
            return $this->createBenne();
        } else if ($flux->categorie == 'DDS') {
            return $this->createDDS();
        } else {
            return $this->createAutre();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\RequeteNouvelleCommande  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequeteNouvelleCommande $request)
    {
        
        $inputs = $request->all();
        session()->put(['inputs' => $inputs]);
        $flux = Flux::find($inputs['flux']);
        $dechet = Dechetterie::find($inputs['dechetterie']);
        $multiplicite = $inputs['multiplicite'];
        return view('saisie/nouvelleCommande/confirmationCommande')->with('flux', $flux)
        ->with('dechetterie', $dechet)
        ->with('multiplicite', $multiplicite);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmStore(Confirmation $requestConfirm)
    {
        $numero_groupe = Commande::all()->max('numero_groupe')+1;
        var_dump($numero_groupe );
        $inputs = session()->get('inputs');
        $inputs['compte'] = $requestConfirm->all()['compte'];
        $inputs['numero_groupe'] = $numero_groupe;
        $commande = $this->commandeRepository->store($inputs);

        if (session()->has('commandes')) {
            foreach (session()->get('commandes') as $inputs) {
                $inputs['compte'] = $requestConfirm->all()['compte'];
                $inputs['numero_groupe'] = $numero_groupe;
                $commande = $this->commandeRepository->store($inputs);
            }

            return redirect('saisie/commandes')->withOk('Les commandes ont bien été passées.');
        }

        
        return redirect('saisie/commandes')->withOk('La commande a bien été passée.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $commande = $this->commandeRepository->getById($id);

		return view('saisie/vueCommande',  compact('commande'));
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroupe($idGr)
    {
        $commandes = $this->commandeRepository->getByGroupe($idGr);

		return view('saisie/gr/vueCommande',  compact('commandes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $commande = $this->commandeRepository->getById($id);
        $fluxx = ControllerDonneesSaisie::flux($commande->getFlux()->categorie);
        $dechetteries = ControllerDonneesSaisie::dechetteries();

        if ($commande->getFlux()->categorie == 'Benne') {
            return view('saisie/modificationCommande/modificationCommandeBenne',  compact('commande','fluxx','dechetteries'));
        }
        else if ($commande->getFlux()->categorie == 'DDS'){
            return view('saisie/modificationCommande/modificationCommandeDDS',  compact('commande','fluxx','dechetteries'));
        }
        else {
            return view('saisie/modificationCommande/modificationCommandeAutres',  compact('commande','fluxx','dechetteries'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RequeteModifCommande  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequeteModifCommande $request, $id)
    {
        $inputs = $request->all();
        session()->put(['inputs' => $inputs]);
        $flux = Flux::find($inputs['flux']);
        $dechet = Dechetterie::find($inputs['dechetterie']);
        $multiplicite = $inputs['multiplicite'];
        return view('saisie/modificationCommande/confirmationModif')->with('flux', $flux)
        ->with('dechetterie', $dechet)
        ->with('multiplicite', $multiplicite);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Confirmation
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmUpdate(Confirmation $requestConfirm)
    {
        $inputs = session()->get('inputs');
        $inputs['compte'] = $requestConfirm->all()['compte'];
        $commande = $this->commandeRepository->update($inputs,"Modifiée");
        return redirect('saisie/commandes')->withOk('La commande a été modifiée.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commande = $this->commandeRepository->getByID($id);
        $flux = $commande->getFlux();
        $dechet = $commande->getDechetterie();
        $multiplicite = $commande->multiplicite;
        session()->put(['numero' => $id]);
        return view('saisie/confirmation/confirmSupression')->with('flux', $flux)
        ->with('dechetterie', $dechet)
        ->with('multiplicite', $multiplicite);
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  App\Http\Requests\Confirmation
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Confirmation $request)
    {
        $id = session()->get('numero');
        $compte = $request->all()['compte'];
        $this->commandeRepository->destroy($id,$compte);

		return redirect('saisie/commandes')->withOk("La commande a été suprimée.");
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response0
     */
    public function rappel($id)
    {
        $commande = $this->commandeRepository->getByID($id);

        $date_enlevement_max = \App\Http\Controllers\ControllerDonneesStats::calculerDateEnlevementMax($commande);
        $date_enlevement_max = Carbon::createFromFormat('Y-m-d H:i:s', $date_enlevement_max);
        $maintenant = Carbon::now();
        if($maintenant->gt($date_enlevement_max)) {
            $flux = $commande->getFlux();
            $dechet = $commande->getDechetterie();
            $multiplicite = $commande->multiplicite;
            session()->put(['numero' => $id]);
            return view('saisie/confirmation/confirmRappel')->with('flux', $flux)
            ->with('dechetterie', $dechet)
            ->with('multiplicite', $multiplicite);
        }
        else {
			session()->put(['error' => 'La commande d\'enlèvement prévue n\'est pas dépassée. Vous ne pouvez pas envoyer de rappel.']);
            return redirect('saisie/commandes');       
        }

        
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rappelGroupe($idGr)
    {
        $commandes = $this->commandeRepository->getByGroupe($idGr);

        $date_enlevement_max = \App\Http\Controllers\ControllerDonneesStats::calculerDateEnlevementMax($commandes->first());
        $date_enlevement_max = Carbon::createFromFormat('Y-m-d H:i:s', $date_enlevement_max);
        $maintenant = Carbon::now();
        if($maintenant->gt($date_enlevement_max)) {
            session()->put(['numero_groupe' => $idGr]);
            return view('saisie/gr/confirmRappel')->with('commandes', $commandes);
        }
        else {
			session()->put(['error' => 'La date d\'enlèvement prévue n\'est pas dépassée. Vous ne pouvez pas envoyer de rappel.']);
            return redirect('saisie/commandes');       
        }

        
    }

/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  App\Http\Requests\Confirmation
     * @return \Illuminate\Http\Response
     */
    public function confirmRappel(Confirmation $request)
    {
        $id = session()->get('numero');
        $compte = $request->all()['compte'];
        $this->commandeRepository->update(['compte' => $compte, 'numero' => $id], "Relancée");

		return redirect('saisie/commandes')->withOk("Un rappel vient d'être envoyé.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  App\Http\Requests\Confirmation
     * @return \Illuminate\Http\Response
     */
    public function confirmRappelGroupe(RequeteRappelGroupe $request)
    {

        $idGr = session()->get('numero_groupe');
        $compte = $request->all()['compte'];
        $commandes = $request->all()['commandes_rappelees'];
        foreach ($commandes as $id) {
            $this->commandeRepository->update(['compte' => $compte, 'numero' => $id], "Relancée");
        }

		return redirect('saisie/commandes')->withOk("Un rappel vient d'être envoyé pour les commandes concernées.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function formulaireValidation($id)
    {
        $commande = $this->commandeRepository->getById($id);
        if($commande->statut != 'En attente d\'envoie') {
            session()->put(['numero' => $id]);
            return view('saisie/validation')->with('commande',$commande);
        }
        else {
			session()->put(['error' => 'La commande n\'a pas encore été envoyée. Vous ne pouvez pas la valider.']);
            return redirect('saisie/commandes');       
        }
        
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function formulaireValidationGroupe($idGr)
    {
        
        $commandes = $this->commandeRepository->getByGroupe($idGr);

        if($commandes->first->statut != 'En attente d\'envoie') {
            session()->put(['numero_groupe' => $idGr]);
            return view('saisie/gr/validation')->with('commandes', $commandes);
        }
        else {
			session()->put(['error' => 'La date d\'enlèvement prévue n\'est pas dépassée. Vous ne pouvez pas envoyer de rappel.']);
            return redirect('saisie/commandes');       
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Requests\RequeteEnlevement request
     * @return \Illuminate\Http\Response
     */
    public function validation(RequeteEnlevement $request)
    {
        $inputs = $request->all();
        session()->put(['inputs' => $inputs]);
        return view('saisie/confirmation/confirmValidation')->with('nc', $inputs['nc'])
        ->with('date_enlevement', $inputs['date_enlevement']);
    }  

        /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Requests\RequeteEnlevement request
     * @return \Illuminate\Http\Response
     */
    public function validationGroupe(RequeteEnlevementGroupe $request)
    {
        $inputs = $request->all();
        session()->put(['inputs' => $inputs]);
        return view('saisie/gr/confirmValidation')
        ->with('date_enlevement', $inputs['date_enlevement']);
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Requests\Confirmation
     * @return \Illuminate\Http\Response
     */
    public function confirmValidation(Confirmation $requestConfirm)
    {
        $inputs = session()->get('inputs');
        $inputs['numero'] = session()->get('numero');
        $inputs['compte'] = $requestConfirm->all()['compte'];
        $commande = $this->commandeRepository->update($inputs,"Enlevée");
        return redirect('saisie/commandes')->withOk('L\'enlèvement de la commande a été validé.');
    } 

        /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\Requests\Confirmation
     * @return \Illuminate\Http\Response
     */
    public function confirmValidationGroupe(Confirmation $requestConfirm)
    {
        $inputs = session()->get('inputs');
        
        $inputs['compte'] = $requestConfirm->all()['compte'];

        foreach ($inputs['commandes_rappelees'] as $num) {
            $inputs['numero'] = $num;
            $commande = $this->commandeRepository->update($inputs,"Enlevée");
        }

        
        
        return redirect('saisie/commandes')->withOk('Les elèvements ont été validés.');
 
    } 

        /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\RequeteNcAgglo
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajouterNcAgglo(RequeteNcAgglo $requete)
    {
        $this->commandeRepository->setNcAgglo($requete->all());
        return redirect('statistiques')->withOk('La non-conformité a été rajoutée.');
    }

    public function auth_dechet($token)
    {
        $dechetteries = Dechetterie::all();

        foreach ($dechetteries as $dechetterie) {
            if($token == $dechetterie->adresse_mac) {
                session()->put(['dechetterie' => $dechetterie->id]);
                return redirect('saisie/commandes')->withOk('Bienvenue, déchetterie '.$dechetterie->nom.'.');
            }
        }
        return redirect('login')->withError('Veuillez vous authentifier.');
    }    
    
}
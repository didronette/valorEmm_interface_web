<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequeteIncident;
use App\Http\Requests\Confirmation;
use App\Repositories\IncidentRepository;
use App\Repositories\PhotoIncidentRepository;

use App\Dechetterie;

use App\Contacts;
 

class ControllerIncident extends Controller
{
    protected $incidentRepository;
    protected $photoIncidentRepository;

    protected $nbrPerPage = 300;

    public function __construct(IncidentRepository $incidentRepository, PhotoIncidentRepository $photoIncidentRepository)
	{
		$this->incidentRepository = $incidentRepository;
        $this->photoIncidentRepository = $photoIncidentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $differentes_categories = ['Accident matériel' => 'Accident matériel',
        'Accident personne' => 'Accident personne',
        'Atteinte à l\'environnement' => 'Atteinte à l\'environnement',
        'Effraction - vol' => 'Effraction - vol',
        'Incivilité' => 'Incivilité',
        'Dysfonctionnement du site' => 'Dysfonctionnement du site',
        'Autres' => 'Autres'
        ];

        $dechet = Dechetterie::all()->pluck('nom')->toArray();;

        return view('incidents/formulaireNouvelIncident', compact('differentes_categories'))->with('dechetteries', $dechet);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RequeteIncident  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequeteIncident $request)
    {
        $inputs = $request->all();
        session()->put(['inputs' => $inputs]);
        if (!(isset($inputs['dechetterie']))) {
            $inputs['dechetterie'] = session()->get('dechetterie');
        }
        
        // Assigner toutes les trucs à afficher pour la confirmation
        return view('incidents/confirmation')->with('data', $inputs);//->with('flux', $flux)
        //->with('dechetterie', $dechet)
        //->with('multiplicite', $multiplicite);

    }




/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function confirmStore(Confirmation $requestConfirm)
{
    $inputs = session()->get('inputs');
    $inputs['compte'] = $requestConfirm->all()['compte'];    
    $incident = $this->incidentRepository->store($inputs);

    Contacts::mailIncident($incident);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function storebis(Request $request) 
    {
        return "I swear I tried";
        if ($request->hasFile('photo')) {
            //  Let's do everything here
            if ($request->file('photo')->isValid()) {
                //
                /*$validated = $request->validate([
                    'nom' => 'string|max:40',
                    'photo' => 'mimes:jpeg,png|max:1014',
                ]);*/
                $extension = $request->image->extension();
                $request->image->storeAs('/public', $validated['nom'].".".$extension);
                $url = Storage::url($validated['nom'].".".$extension);
                $file = PhotoIncident::create([
                   'nom' => $validated['nom'],
                    'url' => $url,
                ]);
                //Session::flash('success', "Success!");
                //return \Redirect::back();
                return "I swear I tried";
            }
        }
        //abort(500, 'Could not upload image :(');
    }

    public function viewUploads () {
        $images = PhotoIncident::all();
        return view('view_uploads')->with('images', $images);
    }


}

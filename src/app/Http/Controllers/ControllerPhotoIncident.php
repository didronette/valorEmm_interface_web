<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequeteIncident;
use App\Http\Requests\Confirmation;
use App\Http\Requests\RequetePhoto;
use App\Repositories\IncidentRepository;
use App\Repositories\PhotoIncidentRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

use App\Dechetterie;

use App\PhotoIncident;

use App\Contacts;

use App\Incident;

class ControllerPhotoIncident extends Controller
{
    protected $photoIncidentRepository;

    protected $nbrPerPage = 300;

    public function __construct(PhotoIncidentRepository $photoIncidentRepository)
	{
        $this->photoIncidentRepository = $photoIncidentRepository;
    }

    /**
     * Update une photo et renvoi sur la page de confirmation
     *
     * @param  \Illuminate\Http\RequetePhoto  $request
     * @return \Illuminate\Http\Response
     */
    public function storePhoto(RequetePhoto $request)
    {
        $validated = $request->all();
        $extension = $request->photo->extension();
        $date = \Carbon::now()->format('Y/m/d');
        $num_incident= strval(Incident::max('id')+1);
        $request->photo->storeAs('/public', $date.'/'.$num_incident.'/'.$validated['name'].".".$extension);
        $url = Storage::url($date.'/'.$num_incident.'/'.$validated['name'].".".$extension);
        $inputs = [
            'nom' => $validated['name'],
                'url' => $url,
        ];
        $photo = $this->photoIncidentRepository->store($inputs);
        
        if (session()->has('idPhotoIncidentEnCours')) {
            $idPhotoIncidentEnCours = session()->get('idPhotoIncidentEnCours');
            array_push($idPhotoIncidentEnCours, $photo->id);
            session()->put(['idPhotoIncidentEnCours' => $idPhotoIncidentEnCours]);
        }
        else {
            $idPhotoIncidentEnCours = [$photo->id];
            session()->put(['idPhotoIncidentEnCours' => $idPhotoIncidentEnCours]);
        }

        $noms_photos = PhotoIncident::whereIn('id', session()->get('idPhotoIncidentEnCours'))
        ->get(['nom'])->toArray();

        session()->put(['success' => "La photo a bien été uploadée."]);
        $inputs = session()->get('inputs');
        if (!(isset($inputs['dechetterie']))) {
            $inputs['dechetterie'] = session()->get('dechetterie');
        }
        $inputs['noms_photos'] = $noms_photos;
        // Assigner toutes les trucs à afficher pour la confirmation
        return view('incidents/confirmation')->with('data', $inputs);
    }

    public static function updateIdIncident($idIncident)
    {
        if(session()->has('idPhotoIncidentEnCours')) {
            $photos = PhotoIncident::whereIn('id', session()->get('idPhotoIncidentEnCours'))
                ->get();

            foreach ($photos as $photo) {
                $photo->incident = $idIncident;
                $photo->save();
            }
        }
    }

    public static function clearUnrelatedPhoto()
    {
        $photos = PhotoIncident::whereNull('incident')
                ->get();
        foreach ($photos as $photo) {
            File::delete($photo->url); // cette ligen là ne marche pas mais je ne sais pas pourquoi
            $photo->destroy($photo->id);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RequeteNouvelleDechetterie;
use App\Http\Requests\RequeteModifDechetterie;
use App\Repositories\DechetterieRepository;
use Mail;

class ControllerDechetterie extends Controller
{
    protected $dechetterieRepository;

    protected $nbrPerPage = 4;

    public function __construct(DechetterieRepository $dechetterieRepository)
	{
		$this->dechetterieRepository = $dechetterieRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$dechetteries = $this->dechetterieRepository->getPaginate($this->nbrPerPage);
        $links = $dechetteries->render();
        

        //return compact('dechetteries', 'links');
        return view('admin/dechetteries/IndexDechetterie', compact('dechetteries', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/dechetteries/formulaireNouvelleDechetterie'); //formulaireNouvelleDechetterie
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RequeteNouvelleDechetterie  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequeteNouvelleDechetterie $request)
    {
        $dechetterie = $this->dechetterieRepository->store($request->all());
    
        return redirect('admin/dechetteries');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$dechetteries = $this->dechetterieRepository->getById($id);

		return view('admin/dechetteries/VueDechetteries',  compact('dechetteries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$dechetterie = $this->dechetterieRepository->getById($id);

        return view('admin/dechetteries/ModifDechetterie',  compact('dechetterie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\RequeteModifDechetterie  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequeteModifDechetterie $request, $id)
    {
        $this->dechetterieRepository->update($id, $request->all());
		
		return redirect('admin/dechetteries')->withOk("La déchetterie" . $request->input('nom') . " a été modifiée.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$this->dechetterieRepository->destroy($id);

		return back();
    }
}

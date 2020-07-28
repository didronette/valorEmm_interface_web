<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\FluxRepository;
use App\Http\Requests\RequeteNouveauFlux;
use App\Http\Requests\RequeteModifFlux;



class ControllerFlux extends Controller
{
    protected $fluxRepository;
    protected $nbrPerPage = 5;

    public function __construct(FluxRepository $fluxRepository)
	{
		$this->fluxRepository = $fluxRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fluxx = $this->fluxRepository->getPaginate($this->nbrPerPage);
		$links = $fluxx->render();
		return view('admin/flux/IndexFlux',  compact('fluxx', 'links'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/flux/nouveauFlux'); //formulaire du nouveau flux
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\RequeteNouveauFlux  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequeteNouveauFlux $request)
    {
        $flux = $this->fluxRepository->store($request->all());
        return redirect('admin/flux');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$fluxx = $this->fluxRepository->getById($id);

		return view('admin/flux/VueFlux',  compact('fluxx'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fluxx = $this->fluxRepository->getById($id);
      return view('admin/flux/ModifFlux',  compact('fluxx'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request\RequeteModifFlux  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RequeteModifFlux $request, $id)
    {
        $this->fluxRepository->update($id, $request->all());
		
		return redirect('admin/flux')->withOk("Le flux " . $request->input('type')." de la société ".$request->input('societe') . " a été modifié.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$this->fluxRepository->destroy($id);

		return back();
    }
}

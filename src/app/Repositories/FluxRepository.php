<?php

namespace App\Repositories;

use App\Flux;

class FluxRepository
{

    protected $flux;

	public function __construct(Flux $flux)
	{
		$this->flux = $flux;
	}

	private function save(Flux $flux, Array $inputs)
	{
		$flux->societe = $inputs['societe'];
		$flux->type = $inputs['type'];
		$flux->type_contact = $inputs['type_contact'];
		$flux->contact = $inputs['contact'];
		$flux->poids_moyen_benne = $inputs['poids_moyen_benne'];
		$flux->delai_enlevement = $inputs['delai_enlevement'];
		$flux->horaires_commande_matin = $inputs['horaires_commande_matin'];
		$flux->horaires_commande_aprem = $inputs['horaires_commande_aprem'];
		$flux->jour_commande = $inputs['jour_commande'];
		$flux->categorie = $inputs['categorie'];
		$flux->save();
	}

	public function getPaginate($n)
	{
		return $this->flux->paginate($n);
	}

	public function store(Array $inputs)
	{
		$flux = new $this->flux;		

		$this->save($flux, $inputs);

		return $flux;
	}

	public function getById($id)
	{
		return $this->flux->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

}
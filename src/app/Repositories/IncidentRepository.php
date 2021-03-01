<?php

namespace App\Repositories;

use App\Incident;
use Illuminate\Support\Facades\DB;

class IncidentRepository
{

    protected $incident;

	public function __construct(Incident $incident)
	{
		$this->incident = $incident;
	}

	private function save(Incident $incident, Array $inputs)
	{
		$incident->date_heure = $inputs['date_heure'];
		$incident->immatriculation_vehicule = $inputs['immatriculation_vehicule'];
		$incident->type_vehicule = $inputs['type_vehicule'];
		$incident->marque_vehicule = $inputs['marque_vehicule'];
		$incident->couleur_vehicule = $inputs['couleur_vehicule'];
		$incident->description = $inputs['description'];
		$incident->agent = $inputs['agent'];
		$incident->dechetterie = $inputs['dechetterie'];

		$incident->save();
	}

	public function getPaginate($n)
	{
		if ($n==-1) {
			return $this->incident;
		}
		return $this->incident->paginate($n);
	}

	public function store(Array $inputs)
	{
		$incident = new $this->incident;		

		$this->save($incident, $inputs);

		return $incident;
	}

	public function getById($id)
	{
		return $this->incident->findOrFail($id);
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
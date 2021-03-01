<?php

namespace App\Repositories;

use App\PhotoIncident;
use Illuminate\Support\Facades\DB;

class PhotoIncidentRepository
{

    protected $PhotoIncident;

	public function __construct(PhotoIncident $photoIncident)
	{
		$this->incident = $incident;
	}

	private function save(PhotoIncident $photoIncident, Array $inputs)
	{
		$photoIncident->incident = $inputs['incident'];
		$photoIncident->photo = $inputs['photo'];		

		$photoIncident->save();
	}

	public function getPaginate($n)
	{
		if ($n==-1) {
			return $this->photoIncident;
		}
		return $this->photoIncident->paginate($n);
	}

	public function store(Array $inputs)
	{
		$photoIncident = new $this->photoIncident;		

		$this->save($photoIncident, $inputs);

		return $photoIncident;
	}

	public function getById($id)
	{
		return $this->photoIncident->findOrFail($id);
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
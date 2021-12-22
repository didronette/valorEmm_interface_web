<?php

namespace App\Repositories;

use App\PhotoIncident;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class PhotoIncidentRepository
{

    protected $PhotoIncident;

	public function __construct(PhotoIncident $photoIncident)
	{
		$this->photoIncident = $photoIncident;
	}

	private function save(PhotoIncident $photoIncident, Array $inputs)
	{		
		$photoIncident->nom = $inputs['nom'];	
		$photoIncident->url = $inputs['url'];				

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

		;

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
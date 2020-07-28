<?php

namespace App\Repositories;

use App\Dechetterie;
use Illuminate\Support\Facades\DB;

class DechetterieRepository
{

    protected $dechetterie;

	public function __construct(Dechetterie $dechetterie)
	{
		$this->dechetterie = $dechetterie;
	}

	private function save(Dechetterie $dechetterie, Array $inputs)
	{
		$dechetterie->NOM = $inputs['nom'];
		$dechetterie->ADRESSE_MAC = $inputs['adresse_mac'];		

		$dechetterie->save();
	}

	public function getPaginate($n)
	{
		if ($n==-1) {
			return $this->dechetterie;
		}
		return $this->dechetterie->paginate($n);
	}

	public function store(Array $inputs)
	{
		$dechetterie = new $this->dechetterie;		

		$this->save($dechetterie, $inputs);

		return $dechetterie;
	}

	public function getById($id)
	{
		return $this->dechetterie->findOrFail($id);
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
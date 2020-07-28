<?php

namespace App\Repositories;

use App\Compte;

class CompteRepository
{

    protected $compte;

	public function __construct(Compte $compte)
	{
		$this->compte = $compte;
	}

	private function save(Compte $compte, Array $inputs)
	{
		$compte->nom_utilisateur = $inputs['nom_utilisateur'];
		$compte->adresse_mail = $inputs['adresse_mail'];	
		$compte->type = $inputs['type'];	

		$compte->save();
	}

	public function getPaginate($n)
	{
		return $this->user->paginate($n);
	}

	public function store(Array $inputs)
	{
		$compte = new $this->compte;		
		$compte->hash_mdp = bcrypt('Ceciestunmdp'); // Méthode de cryptage pour les mdp

		$this->save($compte, $inputs);

		return $user;
	}

	public function getById($id)
	{
		return $this->compte->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
	
	public static function getSysteme()
	{
		return \App\Compte::where('name','Système');
	}
}
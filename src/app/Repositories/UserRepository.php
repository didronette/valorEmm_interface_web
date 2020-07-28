<?php

namespace App\Repositories;

use App\User;

class UserRepository
{

    protected $user;

    public function __construct(User $user)
	{
		$this->user = $user;
	}

	private function save(User $user, Array $inputs)
	{
		$user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->type = $inputs['type'];	

        $user->save();
        

	}

	public function getPaginate($n)
	{
		return $this->user->where('name','!=','Système')->paginate($n);
	}

	public function store(Array $inputs)
	{
		$user = new $this->user;		
		$user->password = bcrypt($inputs['password']);

		$this->save($user, $inputs);

		return $user;
	}

	public function getById($id)
	{
		return $this->user->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$user = $this->getById($id);
		if (isset($inputs['password'])) {
			$user->password = bcrypt($inputs['password']);
		}
		$this->save($user, $inputs);

		return $this->getById($id);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

	public static function getSysteme()
	{
		return User::where('name','Système')->first();
	}

}
<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequeteNouveauUser;
use App\Http\Requests\RequeteModifUser;
use App\Http\Controllers\ControllerAdmin;

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Hash;



use Illuminate\Http\Request;

class ControllerUser extends Controller
{

    protected $userRepository;

    protected $nbrPerPage = 4;

    public function __construct(UserRepository $userRepository)
    {
		$this->userRepository = $userRepository;
	}

	public function index()
	{
		$users = $this->userRepository->getPaginate($this->nbrPerPage);
		$links = $users->render();

		return view('admin/user/indexComptes', compact('users', 'links'));
	}

	public function create()
	{
		return view('admin/user/nouveauCompte');
	}

	public function store(RequeteNouveauUser $request)
	{
		if(!($this->motDePasseValide($request->all()))) {
			session()->put(['error' => 'Le code PIN saisi existe déjà pour un autre agent.']);
			return redirect('admin/comptes');
		}

		$user = $this->userRepository->store($request->all());
		ControllerAdmin::mailNouveauCompte($user,$request->all()['password']);
		return redirect('admin/comptes')->withOk("L'utilisateur " . $user->name . " a été créé.");
	}

	public function show($id)
	{
		$user = $this->userRepository->getById($id);

		return view('admin/user/VueComptes',  compact('user'));
	}

	public function edit($id)
	{
		$user = $this->userRepository->getById($id);
		return view('admin/user/ModifComptes',  compact('user'));
	}

	public function update(RequeteModifUser $request, $id)
	{
		if(!($this->motDePasseValide($request->all()))) {
			session()->put(['error' => 'Le code PIN saisi existe déjà pour un autre agent.']);
			return redirect('admin/comptes');
		}
		$user = $this->userRepository->update($id, $request->all());
		ControllerAdmin::mailModifCompte($user,$request->all()['password']);
		return redirect('admin/comptes')->withOk("L'utilisateur " . $request->input('name') . " a été modifié.");
	}

	public function destroy($id)
	{
		$this->userRepository->destroy($id);

		return back();
	}

	public function motDePasseValide($inputs)
	{
		if($inputs['type'] == 'Agent') {
			$mdp = $inputs['password'];
			$agents = User::where('type', '=', 'Gardien')->get();
			foreach ($agents as $agent) {
				if (Hash::check($mdp, $agent->password)) {
					return false;
				}
			}
		}
		return true;
	}

}
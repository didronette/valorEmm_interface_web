@extends('mails/mail')

@section('nom')
    {!! $user->name !!}
@endsection

@section('content')
    <div>
        Votre compte sur l'interface web de Valor'Emm de gestion des déchetteries de la CAFPF vient d'être modifié ! Récapitulatif : 
         <ul> 
         <li>Nom d'utilisateur : {!! $user->name !!}</li>
         <li>Adresse mail : {!! $user->email !!}</li>
         <li>Type du compte : {!! $user->type !!}</li>
         @if(isset($password))
            <li>Nouveau mot de passe : {!! $password !!}</li>
		@endif            
        </ul>
    </div>
@endsection
@extends('mails/mail')

@section('nom')
    {!! $user->name !!}
@endsection

@section('content')
    <div>
        Un compte {!! $user->type !!} vient de vous être créé sur l'interface web de Valor'Emm de gestion des déchetteries de la CAFPF. Vos identifiants sont les suivants :
        <ul> 
            <li>Adresse mail : {!! $user->email !!}</li>
            <li>Mot de passe : {!! $password !!}</li>
        </ul>
    </div>
@endsection
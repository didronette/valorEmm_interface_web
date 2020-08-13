@extends('saisie/confirmation')


@section('titre')
    Rappel
@endsection


@section('text')
    Vous êtes sur le point d'envoyer un rappel pour la commande suivante : <br>
    <ul>
    <li>Catégorie : {!! $flux->categorie !!}</li>
    <li>Flux : {!! $flux->type !!} (x{!! $multiplicite !!})</li>
    <li>À : {!! $flux->societe !!}</li>
    @if(!(session()->has('dechetterie')))
        <li>Déchetterie : {!! $dechetterie->nom  !!}</li>
    @endif
    
</ul>

    {!! Form::open(['route' => 'confirmerRappel']) !!}


@endsection

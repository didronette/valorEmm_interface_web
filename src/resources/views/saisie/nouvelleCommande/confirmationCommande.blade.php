@extends('saisie/confirmation')


@section('titre')
    Confirmation de commande
@endsection


@section('text')
    Résumé de la commande : <br>
    <ul>
    <li>Catégorie : {!! $flux->categorie !!}</li>
    <li>Flux : {!! $flux->type !!} (x{!! $multiplicite !!})</li>
    <li>À : {!! $flux->societe !!}</li>
    @if(!(session()->has('dechetterie')))
        <li>Déchetterie : {!! $dechetterie->nom  !!}</li>
    @endif
    
</ul>

    {!! Form::open(['route' => 'confirmerNouvelleCommande']) !!}


@endsection

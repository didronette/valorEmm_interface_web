@extends('saisie/confirmation')


@section('titre')
    Confirmation de rappel groupé
@endsection


@section('text')
    Vous êtes sur le point d'envoyer un rappel pour le groupe de commande suivant : <br>
    <ul>
    <li>Catégorie : {!! $commandes->first()->getFlux()->categorie !!}</li>
    <li>Numéro de groupe : {!! $commandes->first()->numero_groupe !!}</li>
    
</ul>
<div>
Veuillez selectionner les commandes enlevées :


</div>

    {!! Form::open(['route' => 'confirmerRappelGr']) !!}

    @foreach ($commandes as $commande)
    {!! Form::label($commande->numero,$commande->getFlux()->type.'('.$commande->getFlux()->societe.','.$commande->multiplicite.')' ) !!}
    {!! Form::checkbox($commande->numero, $commande->numero,true) !!} 
@endforeach 
@endsection

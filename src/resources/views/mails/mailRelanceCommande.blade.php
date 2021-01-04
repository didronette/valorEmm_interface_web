@extends('mails/mail')

@section('nom')
    société {{ $commandes->first()->getFlux()->societe }}
@endsection

@section('content')
La commande numéro {!! $commande->numero !!} n'a pas été enlevée. Voici les informations associées à cette commande :
<ul>
    <li>Flux : {{ $commande->getFlux()->type  }}</li>
    <li>Catégorie : {{ $commande->getFlux()->categorie }}</li>
    <li>Nombre : {{ $commande->multiplicite }}</li>
    <li>Déchetterie : {{ $commande->getDechetterie()->nom }}</li>
</ul>
    
@endsection
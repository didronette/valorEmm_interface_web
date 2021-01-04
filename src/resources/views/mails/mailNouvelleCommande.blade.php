@extends('mails/mail')

@section('nom')
    société {{ $commandes->first()->getFlux()->societe }}
@endsection

@section('content')
Voici la(es) commande(s) du jour :
@foreach ($commandes as $commande)
<div>
    <ul>
        <li>Numéro : {{ $commande->numero }}</li>
        <li>Flux : {{ $commande->getFlux()->type  }}</li>
        <li>Catégorie : {{ $commande->getFlux()->categorie }}</li>
        <li>Nombre : {{ $commande->multiplicite }}</li>
        <li>Déchetterie : {{ $commande->getDechetterie()->nom }}</li>
    </ul>
    <br>
</div> 
@endforeach  
@endsection
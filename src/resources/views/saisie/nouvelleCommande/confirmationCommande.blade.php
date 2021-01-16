@extends('saisie/confirmation')


@section('titre')
    Confirmation de commande
@endsection


@section('text')
    @if (session()->has('commandes'))
        Vous allez passer {{ count(session()->get('commandes')) }} autres commandes : <br>
        @foreach (session()->get('commandes') as $commande)
        Résumé de la commande : <br>
        <ul>
            <li>Catégorie : {!! Flux::find($commande['flux'])->categorie !!}</li>
            <li>Flux : {!! Flux::find($commande['flux'])->type !!} (x{!! $commande['multiplicite'] !!})</li>
            <li>À : {!! $Flux::find(commande['flux'])->societe !!}</li>
 
        </ul>
        @endforeach
        
    @endif

        Résumé de la commande : <br>
        <ul>
        <li>Catégorie : {!! $flux->categorie !!}</li>
        <li>Flux : {!! $flux->type !!} (x{!! $multiplicite !!})</li>
        <li>À : {!! $flux->societe !!}</li>
        @if(!(session()->has('dechetterie')))
            <li>Déchetterie : {!! $dechetterie->nom  !!}</li>
        @endif
    
    
    {!! Form::open(['route' => 'ajouterPlusieursCommandes']) !!}
    {!! Form::submit('Ajouter une commande', ['class' => 'btn btn-success']) !!}
    {!! Form::close() !!}
</ul>

    {!! Form::open(['route' => 'confirmerNouvelleCommande']) !!}


@endsection

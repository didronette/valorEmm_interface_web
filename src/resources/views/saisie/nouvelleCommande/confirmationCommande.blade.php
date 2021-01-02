@extends('saisie/confirmation')


@section('titre')
    Confirmation de commande
@endsection


@section('text')
    @if (session()->has('commandes'))
        Vous allez passer {{ count(session()->get('commandes')) }} autres commandes : <br>
        
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

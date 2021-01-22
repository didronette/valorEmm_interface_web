@extends('templatePage')

@section('titre')
    Visualisation de commande groupée
@endsection

@section('contenu')
    <div class="col-sm-offset-4 col-sm-6">
    	<br>
		<div class="panel panel-primary" id="yellow">
        Numéro de groupe : {{ $commandes->first()->numero_groupe}}
        @foreach($commandes as $commande)	
			<div class="panel-body"> 
				<p>Numéro : {{ $commande->numero }}</p>
                <p>Catégorie : {{ $commande->getFlux()->categorie }}</p>
				<p>Flux : {{ $commande->getFlux()->type  }} ({{$commande->getFlux()->societe}})</p>
                <p>Nombre : {{ $commande->multiplicite }}</p>
                <p>Déchetterie : {{ $commande->getDechetterie()->nom }}</p>
                <p>Responsable : {{ $commande->getUser()->name }} </p>
				<p>Statut : {{ $commande->statut }}</p>
				<p>Date d'envoi : {{ $commande->contact_at }}</p>
				<p>Date d'enlèvement maximum : {{ \App\Http\Controllers\ControllerDonneesStats::calculerDateEnlevementMax($commande) }}</p>
				<p>{{ $commande->todo }}</p>
			</div>
        @endforeach
		</div>	


		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
	</div>


@endsection
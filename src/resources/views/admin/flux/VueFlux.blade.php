@extends('templatePage')

@section('titre')
    Visualisation de flux
@endsection

@section('contenu')
    <div class="col-sm-offset-5 col-sm-4">
		<div class="panel panel-primary" id="yellow">	
			<div class="panel-body"> 
				<p>Catégorie : {{ $fluxx->categorie }}</p>
                <p>Société : {{ $fluxx->societe }}</p>
                <p>Type : {{ $fluxx->type }}</p>
                <p>Contact : {{ $fluxx->contact }} ({{ $fluxx->type_contact }})</p>
                <p>Poids moyen d'un contenant : {{ $fluxx->poids_moyen_benne }} </p>
                <p>Délai d'enlèvement (en heure) : {{ $fluxx->delai_enlevement }} </p>
                <p>Horraire de commande : {{ $fluxx->horaires_commande_matin }} {{ $fluxx->horaires_commande_aprem }} </p>
                <p>Jour de commande : {{ $fluxx->jour_commande }} </p>
			</div>
		</div>				
		<a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
	</div>
@endsection
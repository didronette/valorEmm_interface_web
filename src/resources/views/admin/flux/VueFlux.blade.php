@extends('templatePage')

@section('titre')
    Visualisation de flux
@endsection

@section('contenu')
    <div class="col-sm-offset-4 col-sm-4">
    	<br>
		<div class="panel panel-primary">	
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
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection
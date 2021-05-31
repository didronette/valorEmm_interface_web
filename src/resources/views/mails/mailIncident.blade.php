@extends('mails/mail')

@section('nom')
    CAPF 
@endsection

@section('content')
<div>
    Un incident vient d'être reporté pour la déchetterie de {!! $incident->getDechetterie()->nom !!} par {!! $incident->getAgent()->name !!}. 
    L'incident est survenu le {!! \Carbon::createFromFormat('Y-m-d H:i',$incident->date_heure) !!}. 

    <ul>
    <li>Catégorie de l'incident : {!! $incident->categorie !!}</li>
    <li>Description de l'incident : {!! $incident->description !!}</li>
    <li>Réponse apportée : {!! $incident->reponse_apportee !!}</li>

    @if(isset($incident->type_vehicule)) 
    <li>Type du véhicule : {!! $incident->type_vehicule !!}</li>
    <li>Marque du véhicule : {!! $incident->marque_vehicule !!}</li>
    <li>Couleur du véhicule : {!! $incident->couleur_vehicule !!}</li>
    <li>Immatriculation du véhicule : {!! $incident->immatriculation !!}</li>
    <li>Numéro Sidem Pass : {!! $incident->numero_sidem_pass !!}</li>
	@endif

    </ul>
    <!--Photos de l'incident :-->
    
    <!-- insérer les photos -->

	
</div>
@endsection
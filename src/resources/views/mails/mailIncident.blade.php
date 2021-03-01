@extends('mails/mail')

@section('nom')
    {!! CAPF !!}
@endsection

@section('content')
<div>
    Un incident vient d'être reporté pour la déchetterie de {!! $incident->getDechetterie()) !!} par {!! $incident->getAgent() !!}. L'incident est survenu le {!! \Carbon::createFromFormat('Y-m-d H:i:s',$incident->date_heure) !!}. 

    Description de l'incident : {!! $incident->description !!}

    @if(isset($incident->type_vehicule)) 
		Type du véhicule : $incident->type_vehicule
        Marque du véhicule : $incident->marque_vehicule
        Couleur du véhicule : $incident->couleur_vehicule
        Immatriculation du véhicule : $incident->immatriculation
        Numéro Sidem Pass : $incident->numero_sidem_pass
	@endif

    Photos de l'incident :

    <!-- insérer les photos -->
</div>
@endsection
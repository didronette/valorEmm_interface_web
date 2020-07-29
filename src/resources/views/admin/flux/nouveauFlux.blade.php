@extends('templatePage')

@section('titre')
    Nouveaux flux
@endsection


@section('contenu')

<div class="col-sm-offset-5 col-sm-4">

<div class="panel panel-primary" id="yellow">	
			<div class="panel-body">

                {!! Form::open(['route' => 'flux.store','method' => 'post','id' => 'yellow']) !!}	

                <div class="form-group {!! $errors->has('categorie') ? 'has-error' : '' !!}">
						{!! Form::select('categorie', ['Bennes' => 'Bennes','DDS' => 'DDS','Autres déchets' => 'Autres déchets'], null,['class' => 'form-control', 'placeholder' => 'Catégorie']) !!}
						{!! $errors->first('categorie', '<small class="help-block">:message</small>') !!}
					</div> 

					<div class="form-group {!! $errors->has('societe') ? 'has-error' : '' !!}">
						{!! Form::text('societe', null, ['class' => 'form-control', 'placeholder' => 'Société']) !!}
						{!! $errors->first('societe', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('type') ? 'has-error' : '' !!}">
						{!! Form::text('type', null, ['class' => 'form-control', 'placeholder' => 'Intitulé du flux']) !!}
						{!! $errors->first('type', '<small class="help-block">:message</small>') !!}
					</div>

                    <div class="form-group {!! $errors->has('type_contact') ? 'has-error' : '' !!}">
						{!! Form::select('type_contact', array('SMS' => 'SMS','APPEL' => 'APPEL','MAIL' => 'MAIL'), null,['class' => 'form-control', 'placeholder' => 'Type du contact']) !!}
						{!! $errors->first('type_contact', '<small class="help-block">:message</small>') !!}
					</div> 

					<div class="form-group {!! $errors->has('contact') ? 'has-error' : '' !!}">
						{!! Form::text('contact', null, ['class' => 'form-control', 'placeholder' => 'Contact']) !!}
						{!! $errors->first('contact', '<small class="help-block">:message</small>') !!}
					</div>

                    <div class="form-group {!! $errors->has('poids_moyen_benne') ? 'has-error' : '' !!}">
						{!! Form::text('poids_moyen_benne', null, ['class' => 'form-control', 'placeholder' => 'Poids moyen d\'une benne']) !!}
						{!! $errors->first('poids_moyen_benne', '<small class="help-block">:message</small>') !!}
					</div>

                    <div class="form-group {!! $errors->has('delai_enlevement') ? 'has-error' : '' !!}">
						{!! Form::text('delai_enlevement', null, ['class' => 'form-control', 'placeholder' => 'Délai d\'enlèvement (en heure)']) !!}
						{!! $errors->first('delai_enlevement', '<small class="help-block">:message</small>') !!}
					</div>

                    <div class="form-group {!! $errors->has('horaires_commande_matin') ? 'has-error' : '' !!}">
						{!! Form::time('horaires_commande_matin', null, ['class' => 'form-control', 'placeholder' => 'Horaires de commande pour le matin']) !!}
						{!! $errors->first('horaires_commande_matin', '<small class="help-block">:message</small>') !!}
					</div>

                    <div class="form-group {!! $errors->has('horaires_commande_aprem') ? 'has-error' : '' !!}">
						{!! Form::time('horaires_commande_aprem', null, ['class' => 'form-control', 'placeholder' => 'Horaires de commande pour l\'après-midi']) !!}
						{!! $errors->first('horaires_commande_aprem', '<small class="help-block">:message</small>') !!}
					</div>                  

                    <div class="form-group {!! $errors->has('jour_commande') ? 'has-error' : '' !!}">
						{!! Form::text('jour_commande', null, ['class' => 'form-control', 'placeholder' => 'Jour où la commande est possible']) !!}
						{!! $errors->first('jour_commande', '<small class="help-block">:message</small>') !!}
					</div>  


					{!! Form::submit('Ajouter',['class' => 'btn btn-success pull-right']) !!}
					{!! Form::close() !!}
		
					</div>
		</div>
					<a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>

		
		</div>


@endsection
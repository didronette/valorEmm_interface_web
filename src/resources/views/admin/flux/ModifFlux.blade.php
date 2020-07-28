@extends('templatePage')

@section('titre')
    Modification de flux
@endsection

@section('contenu')
    <div class="col-sm-offset-4 col-sm-4">
    	<br>
		<div class="panel panel-primary">	
			<div class="panel-body"> 
				<div class="col-sm-12">
                    <div class="row">
                            
                        {!! Form::model($fluxx, ['route' => ['flux.update', $fluxx->id], 'method' => 'put', 'class' => 'form-horizontal panel']) !!}
                        <div class="column">
                <div class="form-group {!! $errors->has('categorie') ? 'has-error' : '' !!}">
						{!! Form::select('categorie', ['Benne' => 'Benne','DDS' => 'DDS','Autres déchets' => 'Autres déchets'], $fluxx->categorie,['class' => 'form-control', 'placeholder' => 'Catégorie']) !!}
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
						{!! Form::select('type_contact', ['SMS' => 'SMS','APPEL' => 'APPEL','MAIL' => 'MAIL'], $fluxx->type_contact,['class' => 'form-control', 'placeholder' => 'Type du contact']) !!}
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
                    </div>
                    <div class="column">

                    <div class="form-group {!! $errors->has('horaires_commande_matin') ? 'has-error' : '' !!}">
						{!! Form::time('horaires_commande_matin', $fluxx->horaires_commande_matin, ['class' => 'form-control', 'placeholder' => 'Horaires de commande pour le matin']) !!}
						{!! $errors->first('horaires_commande_matin', '<small class="help-block">:message</small>') !!}
					</div>

                    <div class="form-group {!! $errors->has('horaires_commande_aprem') ? 'has-error' : '' !!}">
						{!! Form::time('horaires_commande_aprem', $fluxx->horaires_commande_aprem, ['class' => 'form-control', 'placeholder' => 'Horaires de commande pour l\'après-midi']) !!}
						{!! $errors->first('horaires_commande_aprem', '<small class="help-block">:message</small>') !!}
					</div>                  

                    <div class="form-group {!! $errors->has('jour_commande') ? 'has-error' : '' !!}">
						{!! Form::text('jour_commande', null, ['class' => 'form-control', 'placeholder' => 'Jour où la commande est possible']) !!}
						{!! $errors->first('jour_commande', '<small class="help-block">:message</small>') !!}
					</div>  
                    {!! Form::submit('Envoyer', ['class' => 'btn btn-primary pull-right']) !!}
                    </div>
                            
                        {!! Form::close() !!}
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon glyphicon-circle-arrow-left"></span> Retour
		</a>
	</div>
@endsection
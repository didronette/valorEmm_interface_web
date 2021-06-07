@extends('templatePage')

@section('titre')
    Nouvel Incident
@endsection


@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">

	<div class="panel panel-primary">	
			<div class="panel-body" id="yellow"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'inc.store','id' => "yellow-borderless"]) !!}	

					<div class="form-group {!! $errors->has('categorie') ? 'has-error' : '' !!}">
                            {!! Form::select('categorie',$differentes_categories,null, ['class' => 'form-control', 'placeholder' => 'Selection de la catégorie']) !!}
                            {!! $errors->first('categorie', '<small class="help-block">:message</small>') !!}
                    </div>

                    @if(session()->has('dechetterie'))
                        
						{!! Form::hidden('dechetterie', session()->get('dechetterie')) !!}
                    @else
					<div class="form-group {!! $errors->has('dechetterie') ? 'has-error' : '' !!}">
                                {!! Form::select('dechetterie',$dechetteries,null, ['class' => 'form-control', 'placeholder' => 'Selection de la déchetterie']) !!}
                                {!! $errors->first('dechetterie', '<small class="help-block">:message</small>') !!}
                        </div>
		            @endif

					<div class="form-group {!! $errors->has('date_incident') ? 'has-error' : '' !!}">
                            {!! Form::label('date_incident', 'Date de l\'incident :') !!}
                            {!! Form::date('date_incident', date('Y-m-d'), ['class' => 'form-control', 'placeholder' => 'Date de l\'incident']) !!}
                            {!! $errors->first('date_incident', '<small class="help-block">:message</small>') !!}
                        </div>

                        <div class="form-group {!! $errors->has('heure_incident') ? 'has-error' : '' !!}">
                            {{ Form::time('heure_incident',date('H:i'), ['class' => 'form-control', 'placeholder' => 'Heure de l\'incident']) }} 
                            {!! $errors->first('heure_incident', '<small class="help-block">:message</small>') !!}
                        </div>

					<div class="form-group {!! $errors->has('immatriculation_vehicule') ? 'has-error' : '' !!}">
						{!! Form::text('immatriculation_vehicule', null, ['class' => 'form-control', 'placeholder' => 'Immatriculation du véhicule']) !!}
						{!! $errors->first('immatriculation_vehicule', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('type_vehicule') ? 'has-error' : '' !!}">
						{!! Form::text('type_vehicule', null, ['class' => 'form-control', 'placeholder' => 'Type du véhicule']) !!}
						{!! $errors->first('type_vehicule', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('marque_vehicule') ? 'has-error' : '' !!}">
						{!! Form::text('marque_vehicule', null, ['class' => 'form-control', 'placeholder' => 'Marque du véhicule']) !!}
						{!! $errors->first('marque_vehicule', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('couleur_vehicule') ? 'has-error' : '' !!}">
						{!! Form::text('couleur_vehicule', null, ['class' => 'form-control', 'placeholder' => 'Couleur du véhicule']) !!}
						{!! $errors->first('couleur_vehicule', '<small class="help-block">:message</small>') !!}
					</div>

					<div class="form-group {!! $errors->has('numero_sidem_pass') ? 'has-error' : '' !!}">
						{!! Form::text('numero_sidem_pass', null, ['class' => 'form-control', 'placeholder' => 'Numéro de Sidem Pass']) !!}
						{!! $errors->first('numero_sidem_pass', '<small class="help-block">:message</small>') !!}
					</div>



					<div class="form-group {!! $errors->has('description') ? 'has-error' : '' !!}">
                                {!! Form::textarea('description',null,['class' => 'form-control', 'placeholder' => 'Description']) !!}
                                {!! $errors->first('description', '<small class="help-block">:message</small>') !!}
                        </div>

						<div class="form-group {!! $errors->has('reponse_apportee') ? 'has-error' : '' !!}">
                                {!! Form::textarea('reponse_apportee',null,['class' => 'form-control', 'placeholder' => 'Réponse apportée']) !!}
                                {!! $errors->first('nreponse_apporteec', '<small class="help-block">:message</small>') !!}
                        </div>
					

						@if(session()->has('dechetteries'))
                        <div class="form-group {!! $errors->has('dechetterie') ? 'has-error' : '' !!}">
                                {!! Form::select('dechetterie',$dechetteries,null, ['class' => 'form-control', 'placeholder' => 'Selection de la déchetterie']) !!}
                                {!! $errors->first('dechetterie', '<small class="help-block">:message</small>') !!}
                        </div>
		            @endif

					{!! Form::submit('Ajouter',['class' => "btn btn-success pull-right"]) !!}
					{!! Form::close() !!}
				</div>
			</div>
        
	</div>
	<a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
</div>


@endsection
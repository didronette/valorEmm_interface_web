@extends('templatePage')

@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">

@if(session()->has('error'))
     		<div class="alert alert-danger">{{ session('error') }}</div>
			 <?php session()->forget('error');?>
@endif
<div class="panel panel-primary" id="yellow">	
			<div class="panel-body"> 
				<div class="col-sm-12">
                

    Voici les informations saisies concernant l'incident : <br>
    <ul>
    
    <li>Catégorie de l'incident : {!! $data['categorie'] !!}</li>
    <li>Date et heure de l'incident : {!! $data['date_heure'] !!}</li>
    <li>Description de l'incident : {!! $data['description'] !!}</li>
    <li>Réponse apportée : {!! $data['reponse_apportee'] !!}</li>

    @if(isset($data['type_vehicule'])) 
    <li>Type du véhicule : {!! $data['type_vehicule'] !!}</li>
    <li>Marque du véhicule : {!! $data['marque_vehicule'] !!}</li>
    <li>Couleur du véhicule : {!! $data['couleur_vehicule'] !!} </li>
    <li>Immatriculation du véhicule : {!! $data['immatriculation_vehicule'] !!}</li>
    <li>Numéro Sidem Pass : {!! $data['numero_sidem_pass'] !!}</li>
	@endif
      
    </ul>

                    {!! Form::open(['route' => 'confirmerCreationIncident']) !!}

                    @if(session()->has('dechetterie'))
                        <div class="form-group {!! $errors->has('pin') ? 'has-error' : '' !!}">
                                {!! Form::password('pin', ['class' => 'form-control', 'placeholder' => 'Code PIN']) !!}
                                {!! $errors->first('pin', '<small class="help-block">:message</small>') !!}
                        </div>
                    @else
                        {!! Form::hidden('pin', '0000') !!}

                   
		            @endif

                    {!! Form::submit('Confirmer', ['class' => 'btn btn-block btn-success']) !!}


					{!! Form::close() !!}
				</div>
            </div>
        </div>
		<a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
        </div>
@endsection
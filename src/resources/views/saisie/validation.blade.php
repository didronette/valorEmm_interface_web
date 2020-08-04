@extends('templatePage')

@section('titre')
    Validation d'un enlèvement
@endsection

@section('contenu')
    <div class="col-sm-offset-5 col-sm-4">
    	<br>
		<div class="panel panel-primary" id="yellow">	
			<div class="panel-body"> 
                <div>
                    Vous êtes sur le point de valider la commande suivante : <br>
                    <p>Catégorie : {{ $commande->getFlux()->categorie }}</p>
                    <p>Flux : {{ $commande->getFlux()->type  }} (x {{$commande->multiplicite}} ) ({{$commande->getFlux()->societe}})</p>
                    <p>Déchetterie : {{ $commande->getDechetterie()->nom }}</p>
                </div>
                {!! Form::open(['route' => 'validation']) !!}

                <div class="panel panel-primary">
                    <div class="panel-body">
                        {!! Form::label('checkNC', 'Non-conformité') !!}
                        <input type="checkbox" name="checkNC" onclick="HideorShow();" />

                        <div class="form-group {!! $errors->has('nc') ? 'has-error' : '' !!}">
                                {!! Form::textarea('nc',null,['class' => 'form-control', 'placeholder' => 'Veuillez saisir une description de la non-conformité', 'id' => 'insertinputs', 'style' => 'display:none;']) !!}
                                {!! $errors->first('nc', '<small class="help-block">:message</small>') !!}
                        </div>

                        <link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

                        <div class="form-group {!! $errors->has('date_date_enlevement') ? 'has-error' : '' !!}">
                            {!! Form::label('date_date_enlevement', 'Date de l\'enlèvement :') !!}
                            {!! Form::date('date_date_enlevement', date('Y-m-d'), ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
                            {!! $errors->first('date_date_enlevement', '<small class="help-block">:message</small>') !!}
                        </div>

                        <div class="form-group {!! $errors->has('heure_date_enlevement') ? 'has-error' : '' !!}">
                            {{ Form::time('heure_date_enlevement',date('H:i'), ['class' => 'form-control', 'placeholder' => 'Heure de l\'enlèvement']) }} 
                            {!! $errors->first('heure_date_enlevement', '<small class="help-block">:message</small>') !!}
                        </div>

                        {!! Form::submit('Valider l\'enlèvement', ['class' => 'btn btn-block btn-success']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
		</div>	


        <a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
	</div>


@endsection
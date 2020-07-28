@extends('templatePage')

@section('titre')
    Saisie d'une non-conformité
@endsection

@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">
<div class="panel panel-primary">	
			<div class="panel-body" id="yellow"> 
				<div class="col-sm-12">
                {!! Form::open(['route' => 'storeNcAgglo']) !!}

                        <div class="form-group {!! $errors->has('numero') ? 'has-error' : '' !!}">
                                {!! Form::text('numero',null, ['class' => 'form-control', 'placeholder' => 'Numéro de la commande']) !!}
                                {!! $errors->first('numero', '<small class="help-block">:message</small>') !!}
                        </div>


                        <div class="form-group {!! $errors->has('ncagglo') ? 'has-error' : '' !!}">
                                {!! Form::textarea('ncagglo',null, ['class' => 'form-control', 'placeholder' => 'Veuillez saisir la non-conformité.']) !!}
                                {!! $errors->first('ncagglo', '<small class="help-block">:message</small>') !!}
                        </div>

                    @yield('nombre')

                    {!! Form::submit('Ajouter', ['class' => 'btn btn-block btn-success', 'onclick' => 'return confirm(\'Validez-vous cette non-conformité ?\')']) !!}
					{!! Form::close() !!}
				</div>
            </div>
        </div>
        </div>
@endsection
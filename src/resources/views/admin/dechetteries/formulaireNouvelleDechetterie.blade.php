@extends('templatePage')

@section('titre')
    Nouvelle déchetterie
@endsection


@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">

	<div class="panel panel-primary">	
			<div class="panel-body" id="yellow"> 
				<div class="col-sm-12">
					{!! Form::open(['route' => 'dechetteries.store','id' => "yellow-borderless"]) !!}	
					<div class="form-group {!! $errors->has('nom') ? 'has-error' : '' !!}">
						{!! Form::text('nom', null, ['class' => 'form-control', 'placeholder' => 'Nom']) !!}
						{!! $errors->first('nom', '<small class="help-block">:message</small>') !!}
					</div>
					<div class="form-group {!! $errors->has('adresse_mac') ? 'has-error' : '' !!}">
						{!! Form::text('adresse_mac', null, ['class' => 'form-control', 'placeholder' => 'Adresse MAC']) !!}
						{!! $errors->first('adresse_mac', '<small class="help-block">:message</small>') !!}
					</div>
					
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
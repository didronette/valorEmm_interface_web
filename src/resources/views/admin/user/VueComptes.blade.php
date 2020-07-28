@extends('templatePage')

@section('titre')
    Visualisation de compte
@endsection

@section('contenu')
    <div class="col-sm-offset-5 col-sm-4">
    	<br>
		<div class="panel panel-primary" id="yellow">	
			<div class="panel-body"> 
				<p>Nom : {{ $user->name }}</p>
				<p>Mail : {{ $user->email }}</p>
                <p>Type : {{ $user->type }}</p>
			</div>
		</div>				
		<a href="javascript:history.back()" class="btn btn-primary">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
	</div>
@endsection
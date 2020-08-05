@extends('templatePage')

@section('titre')
    Gestion des commandes
@endsection

@section('contenu')
    <br>
    <div class="col-sm-offset-4 col-sm-6">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		@if(session()->has('error'))
     		<div class="alert alert-danger">{{ session('error') }}</div>
			 <?php session()->forget('error');?>
		@endif
		<div class="panel panel-primary">
		<div class="panel-body" id="yellow"> 
		@if (!$commandes->isEmpty())
			
				
				@foreach ($commandes as $commande)
					<div class="panel panel-primary">
					<table class="table">
						<tbody>
							<tr>
								<td> {!!  $commande->getFlux()->categorie !!} </td>
								<td>{!! $commande->created_at !!}</td>
								@if(!(session()->has('dechetterie'))) 
									<td> Déchetterie : {!! $commande->getDechetterie()->nom !!} </td>
								@endif
							</tr>
							<tr>
								<td>{!! link_to_route('vueGr', 'Voir', [$commande->numero_groupe], ['class' => 'btn btn-success btn-block']) !!}</td>
								<td>		{!! link_to_route('rappelGr', 'Rappel', [$commande->numero_groupe], ['class' => 'btn btn-success']) !!}</td>
								
								<td btn btn-success btn-block> {!! Form::open(['method' => 'GET', 'route' => ['formulaireValidationGr', $commande->numero_groupe]]) !!}
									{!! Form::submit('Valider l\'enlèvement', ['class' => 'btn btn-success btn-block']) !!}
								{!! Form::close() !!} </td>
							</tr>
						
					</tbody>
				</table>

				</div>
				@endforeach
		
		@else
						Il n'y a pas de commande en cours.
		@endif
		</div>
        {!! link_to_route('commandes.index', 'Affichage individuel', ['class' => 'btn btn-warning']) !!}

		</div>
		<table class="table">
						<tbody>
							<tr>
								<td>{!! link_to_route('commandes.create', 'Passer une commande', [], ['class' => 'btn button-val pull-left']) !!}</td>
								<td><a href="https://docagents.valoremm.fr" class="btn button-val center">Documentation</a></td>
								<td>{!! link_to_route('listeContacts', 'Liste des contacts', [], ['class' => 'btn button-val pull-right']) !!}</td>
		 					</tr>
						</tbody>
		</table>
		

		<div >
			{!! $links !!}
		</div>
	<div>
		
	</div>
	</div>
@endsection
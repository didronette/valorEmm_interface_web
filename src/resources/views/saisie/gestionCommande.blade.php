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

		<div >
			{!! $links !!}
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
		
		<div class="panel panel-primary">
		
		{!! link_to_route('indexGr', 'Affichage groupé') !!}
		<div class="panel-body" id="yellow">
		

		
		@if (!$commandes->isEmpty())
			
				
				@foreach ($commandes as $commande)
					@if($commande->todo == "À supprimer") 
						<div class="panel" id="red"> 
					@elseif($commande->todo == "Transmise") 
						<div class="panel" id="green"> 
					@else
						<div class="panel panel-primary">
					@endif
					
					<table class="table">
						<tbody>
							<tr>
								<td> {!!  $commande->getFlux()->type !!} ({!! $commande->multiplicite !!}) </td>
								<td>{!! $commande->created_at !!}</td>
								<td>{!! $commande->todo !!}</td>
								@if(!(session()->has('dechetterie'))) 
									<td> Déchetterie : {!! $commande->getDechetterie()->nom !!} </td>
								@endif
								@if(!(session()->has('dechetterie'))) 
									<td> {!! link_to_route('todoTransmise', 'Marquer "Transmise"', [$commande->numero], ['class' => 'btn btn-success btn-block']) !!} </td>
								@endif
							</tr>
							<tr>
								<td>{!! link_to_route('commandes.show', 'Voir', [$commande->numero], ['class' => 'btn btn-success btn-block']) !!}</td>
								<td>{!! link_to_route('commandes.edit', 'Modifier', [$commande->numero], ['class' => 'btn btn-success btn-block']) !!}</td>
								<td>		{!! link_to_route('rappel', 'Rappel', [$commande->numero], ['class' => 'btn btn-success']) !!}</td>
								
								<td btn btn-success btn-block> {!! Form::open(['method' => 'GET', 'route' => ['formulaireValidation', $commande->numero]]) !!}
									{!! Form::submit('Valider l\'enlèvement', ['class' => 'btn btn-success btn-block']) !!}
								{!! Form::close() !!} </td>
								@if(!(session()->has('dechetterie'))) 
									<td> {!! link_to_route('todoSupprimer', 'Marquer "à supprimer"', [$commande->numero], ['class' => 'btn btn-success btn-block']) !!} </td>
								@endif
							</tr>
						
					</tbody>
				</table>
				</div>
				@endforeach
		
		@else
						Il n'y a pas de commande en cours.
		@endif
		</div>
		

		</div>
		
	<div>
		
	</div>
	</div>
@endsection
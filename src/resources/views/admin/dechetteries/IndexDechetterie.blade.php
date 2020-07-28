@extends('templatePage')

@section('titre')
    Déchetteries
@endsection

@section('contenu')
    <br>
    <div class="col-sm-offset-4 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary">
			<table class="table">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Adresse MAC</th>
						<th></th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
				


					@foreach ($dechetteries as $dechetterie_entity)
						<tr>
						
							<td>{!! $dechetterie_entity->nom !!}</td>
							<td>{!! $dechetterie_entity->adresse_mac !!}</td>
							<td>{!! link_to_route('dechetteries.edit', 'Modifier', [$dechetterie_entity->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['dechetteries.destroy', $dechetterie_entity->id]]) !!}
									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer cette déchetterie ?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
		{!! link_to_route('admin', 'Retour', [], ['class' => 'btn btn-info pull-left']) !!}
		{!! link_to_route('dechetteries.create', 'Ajouter une déchetterie', [], ['class' => 'btn btn-info pull-right']) !!}
		{!! $links !!}
	</div>
@endsection
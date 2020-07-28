@extends('templatePage')

@section('titre')
    Flux
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
					    <th>Catégorie</th>
						<th>Type</th>
						<th>Société</th>
						<th></th>
                        <th></th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($fluxx as $entite)
						<tr>
						<td>{!! $entite->categorie !!}</td>
							<td>{!! $entite->type !!}</td>
							<td>{!! $entite->societe !!}</td>
							<td>{!! link_to_route('flux.show', 'Voir', [$entite->id], ['class' => 'btn btn-success btn-block']) !!}</td>
							<td>{!! link_to_route('flux.edit', 'Modifier', [$entite->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['flux.destroy', $entite->id]]) !!}
									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Voulez-vous vraiment supprimer ce flux ?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
		{!! link_to_route('admin', 'Retour', [], ['class' => 'btn btn-info pull-left']) !!}
		{!! link_to_route('flux.create', 'Ajouter un flux', [], ['class' => 'btn btn-info pull-right']) !!}
		{!! $links !!}
	</div>
@endsection
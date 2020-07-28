@extends('templatePage')

@section('titre')
    Comptes
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
		<div class="panel panel-primary" id="yellow">
			<table class="table">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Type</th>
						<th></th>
                        <th></th>
                        <th></th>
					</tr>
				</thead>
				<tbody>
				
					@foreach ($users as $user_entity)

						<tr>
						
							<td>{!! $user_entity->name !!}</td>
							<td>{!! $user_entity->type !!}</td>
							<td>{!! link_to_route('comptes.show', 'Informations', [$user_entity->id], ['class' => 'btn btn-success btn-success']) !!}</td>
							<td>{!! link_to_route('comptes.edit', 'Modifications', [$user_entity->id], ['class' => 'btn btn-success btn-success']) !!}</td>
							<td>
								{!! Form::open(['method' => 'DELETE', 'route' => ['comptes.destroy', $user_entity->id]]) !!}
									{!! Form::submit('Supression', ['class' => 'btn btn-danger btn-block', 'onclick' => 'return confirm(\'Vraiment supprimer cet utilisateur ?\')']) !!}
								{!! Form::close() !!}
							</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
	
		{!! link_to_route('admin', '&#8634; Retour', [], ['class' => 'btn btn-success pull-left']) !!}
		{!! link_to_route('comptes.create', 'Ajouter un utilisateur', [], ['class' => 'btn btn-success pull-right']) !!}
		{!! $links !!}
	</div>
@endsection
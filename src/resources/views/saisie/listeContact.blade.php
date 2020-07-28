@extends('templatePage')


@section('titre')
    Liste des contacts
@endsection

@section('contenu')
<div class="col-sm-offset-5 col-sm-4">
    	@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		<div class="panel panel-primary" id="yellow">
			<table class="table">
				<thead>
					<tr>
						<th>Société</th>
						<th>Contact</th>
					</tr>
				</thead>
				<tbody>
				


					@foreach ($contacts as $flux)
						<tr>
						
							<td>{!! $flux-> societe !!}</td>
							<td>{!! $flux-> contact!!}</td>
						</tr>
					@endforeach
	  			</tbody>
			</table>
		</div>
		<a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
	</div>
@endsection
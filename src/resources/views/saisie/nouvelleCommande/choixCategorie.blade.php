@extends('templatePage')

@section('titre')
    Nouvelle commande
@endsection

@section('contenu')


<div class="col-sm-offset-5 col-sm-4">
@if(session()->has('error'))
     <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="panel panel-primary position-ref">
	<div class="panel-body" id="yellow"> 

        <div class="grid-aspect flex-center">
        <a href="{{ route('benne') }}" class="btn btn-success">
                    Commande de benne
                </a>
 
        <a href="{{ route('dds') }}" class="btn btn-success">
                    Commande de DDS
                </a>

        <a href="{{ route('autres') }}" class="btn btn-success">
                    Autre commande
                </a>

                </div>
                </div>
                </div>
            <a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
</div>

@endsection
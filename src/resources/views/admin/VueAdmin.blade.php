@extends('templatePage')

@section('titre')
    Section administrateur
@endsection

@section('contenu')


<div class="col-sm-offset-4 col-sm-6">
@if(session()->has('error'))
     <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="panel panel-primary position-ref">
	<div class="panel-body" id="yellow"> 

        <div class="grid-aspect flex-center">
                <a href="{{ route('comptes.index') }}" class="btn btn-success">
                            Gestion des comptes
                        </a>
       
                <a href="{{ route('dechetteries.index') }}" class="btn btn-success">
                            Gestion des déchetteries
                        </a>
       
                <a href="{{ route('flux.index') }}" class="btn btn-success">
                            Gestion des flux
                        </a>
     

            <div>
                Il reste {{ \App\Contacts::creditRestant() }} crédits BuzzExpert.
            </div>
            </div>
        </div>
    </div>


</div>
@endsection
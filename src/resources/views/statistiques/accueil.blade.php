@extends('templatePage')

@section('titre')
    Statistiques
@endsection

@section('contenu')
<div>
@if(session()->has('ok'))
			<div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
		@endif
		@if(session()->has('error'))
     		<div class="alert alert-danger">{{ session('error') }}</div>
			 <?php session()->forget('error');?>
		@endif

<div  class="col-sm-offset-2 col-sm-10">

<div class="panel panel-primary" id="yellow">
<div class="panel-body">
<div class="col-sm-12">
{!! Form::model(['route' => 'updateAccueilAgglo', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
    <div>
        <div class="row">
        <div class="column form-group {!! $errors->has('date_debut') ? 'has-error' : '' !!}">
                                {!! Form::label('date_debut', 'Date de début d\'analyse :') !!}
                                @yield('date_debut')
                                {!! $errors->first('date_debut', '<small class="help-block">:message</small>') !!}
        </div>
        <div class="column form-group {!! $errors->has('date_fin') ? 'has-error' : '' !!}">
                                {!! Form::label('date_fin', 'Date de fin d\'analyse :') !!}
                                @yield('date_fin')
                                {!! $errors->first('date_fin', '<small class="help-block">:message</small>') !!}
        </div>
        </div>
        <div>
            <div>
            <h3>Déchetteries</h3>
            @yield('dechetterie_p')

            </div>
            <div>
  
                <h3>Flux</h3>
                @yield('flux') 
            </div>
        </div>
    </div>

    <div>
    <div class="panel panel-primary">
        <div class="panel-body">
        <div class="col-sm-12">

        <div style="float:left;width:80%;">
        @include('statistiques.stacked_bar_chart')
        </div>
        <div style="float:left;width:20%;">
        <div class="panel panel-primary" id="yellow">
        <div class="panel-body">
        <div class="col-sm-12" style="border-spacing: 30px;"> 
            <div style="padding: 25% 0;"> <strong>Tonnage estimé : {{$tonnes}} tonnes</strong></div>
            <div style="padding: 25% 0;"> <strong>Commandes avec des non-conformités : {{ $pourcentage_enlevement_dans_les_delais }} %</strong></div>
            <div style="padding: 25% 0;"> <strong>Commandes enlevées en retard : {{$pourcentage_nc}} %</strong></div>
        </div>
        </div>
        </div>
        </div>
                </div>
        </div>
        </div>

        
    </div>



    {!! Form::submit('Actualiser', ['class' => 'btn btn-block btn-success' ]) !!}
	{!! Form::close() !!}

    </div>
    </div>
    </div>
    <div class="panel panel-primary col-sm-5" id="yellow" >	

    <div class="panel-body" >
        <div class="col-sm-12" >
        {!! Form::model(['route' => 'generateReport', 'method' => 'post', 'class' => 'form-horizontal panel']) !!}
                <h3> Rapport</h3>
                <div>
                
                {!! Form::label('enlevement','Enlèvement' ) !!}
                {!! Form::checkbox('enlevement', 'enlevement', true) !!}

                {!! Form::label('tonnage','Tonnage' ) !!}
                {!! Form::checkbox('tonnage', 'tonnage', true) !!}

                {!! Form::label('nc','NC' ) !!}
                {!! Form::checkbox('nc', 'nc', true) !!}

                
                {!! Form::submit('Générateur de rapport', ['class' => 'btn btn-block btn-success' ]) !!}

                {!! Form::label('graphique','Graphique' ) !!}
                {!! Form::checkbox('graphique', 'graphique', true) !!}

                {!! Form::label('logs','Logs' ) !!}
                {!! Form::checkbox('logs', 'logs', true) !!}
                </div>
        {!! Form::close() !!}
        </div>
    </div>
    </div>

    <div  class=" col-sm-5" >
    {!! link_to_route('ncAgglo', 'Signaler une non-conformité', [], ['class' => 'btn btn-danger pull-left']) !!}
    </div>
</div>



</div>
@endsection
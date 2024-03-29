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
        <div class="panel panel-primary">
        <div class="panel-body">
        <div class="col-sm-12">
            <h3>Déchetteries</h3>
            @yield('dechetterie_p')
            <button class="btn btn-success" onclick="Decocher('dechetterie');">Tout décocher</button>
            <button class="btn btn-success" onclick="Cocher('dechetterie');">Tout cocher</button>
            </div>
            </div>
            </div>
            <div class="panel panel-primary">
        <div class="panel-body">
        <div class="col-sm-12">
  
                <h3>Flux</h3>
                @yield('flux') 
                <button class="btn btn-success" onclick="Decocher('flux');">Tout décocher</button>
                <button class="btn btn-success" onclick="Cocher('flux');">Tout cocher</button>
            </div>
            </div>
            </div>
            <div class="panel panel-primary">
        <div class="panel-body">
        <div class="col-sm-12">
  
                <h3>Données</h3>
                @yield('donnees') 
            </div>
            </div>
            </div>
        </div>
    </div>

    <div>
    <div class="panel panel-primary" id="capture">
        <div class="panel-body">
        <div class="col-sm-12">

        <div style="float:left;width:80%;">
        @include('statistiques.stacked_bar_chart')
        </div>
        <div style="float:left;width:20%;">
        <div class="panel panel-primary" id="yellow">
        <div class="panel-body">
        <div class="col-sm-12" style="border-spacing: 30px;"> 
            @if($tonnage)
                <div style="padding: 25% 0;"> <strong>Tonnage estimé : {{$tonnes}} tonnes</strong></div>
            @endif
            @if(($nc) || ($ncagglo))
                <div style="padding: 25% 0;"> <strong>Commandes avec des non-conformités : {{$pourcentage_nc}} %</strong></div>
            @endif
            @if ($enlevement)
                <div style="padding: 25% 0;"> <strong>Commandes enlevées en retard : {{ $pourcentage_enlevement_dans_les_delais }} %</strong></div>
            @endif
        </div>
        </div>
        </div>
        </div>
                </div>
        </div>
        </div>

        
    </div>

    

    {!! Form::submit('Actualiser', ['class' => 'btn btn-block btn-success' ]) !!}
    

    </div>
    </div>
    </div>

    
    <div class="panel panel-primary col-sm-5" id="yellow" >	

    <div class="panel-body" >
        <div class="col-sm-12" >
        <h3> Rapport</h3>
        @yield('caseRapport')
	{!! Form::close() !!}
        {!! Form::open(['route' => 'generateReport', 'class' => 'form-horizontal panel','name' => 'formRapport','id' => "yellow-borderless",'onsubmit' => 'submitFormRapport(this)']) !!}
        {{ csrf_field() }} 
            
                

                {!! Form::submit('Générateur de rapport', ['class' => 'btn btn-block btn-success']) !!}
                {!! Form::close() !!}

    
                
        
        </div>
    </div>

    
    </div>

    <div  class=" col-sm-7" >
    

    <div class="panel panel-primary col-sm-5" id="yellow" >	

<div class="panel-body" >
    <div class="col-sm-12" >
    <h3> Rapport d'incidents</h3>
        {!! Form::close() !!}
        <div>
            {!! Form::open(['route' => 'genererRapportIncidents', 'class' => 'form-horizontal panel','name' => 'formRapport','id' => "yellow-borderless",'onsubmit' => 'submitFormRapport(this)']) !!}
            {{ csrf_field() }}
        
            {!! Form::submit('Génération pdf', ['class' => 'btn btn-block btn-success']) !!}
            {!! Form::close() !!}
        </div>
        <div>
        {!! Form::open(['route' => 'genererRapportIncidentsCsv', 'class' => 'form-horizontal panel','name' => 'formRapport','id' => "yellow-borderless",'onsubmit' => 'submitFormRapport(this)']) !!}
    {{ csrf_field() }}
 
        
            {!! Form::submit('Génération CSV', ['class' => 'btn btn-block btn-success']) !!}
            {!! Form::close() !!}
            </div>
    </div>
</div>
</div>




<div class="col-sm-5" >
{!! link_to_route('ncAgglo', 'Signaler une non-conformité', [], ['class' => 'btn btn-danger pull-left']) !!}
</div>

    </div>
</div>



</div>
@endsection
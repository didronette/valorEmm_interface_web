@extends('statistiques.accueil')

@section('flux')

<?php $enlevement = true; $nc=true; $ncagglo=true; $tonnage=true; ?>

@foreach ($fluxx as $flux)
            {!! Form::label('flux:'.strval($flux->id),$flux->type.' ('.$flux->societe.')' ) !!}
            {!! Form::checkbox('flux:'.strval($flux->id), 'flux:'.strval($flux->id),true,['class' => 'flux']) !!} 
        @endforeach 
@endsection

@section('dechetterie_p')
@foreach ($dechetteries as $dechetterie)
                {!! Form::label('dechetterie:'.strval($dechetterie->id),$dechetterie->nom ) !!}
                {!! Form::checkbox('dechetterie:'.strval($dechetterie->id), 'dechetterie:'.strval($dechetterie->id),true,['class' => 'dechetterie']) !!}

            @endforeach              
@endsection

@section('date_debut')
{!! Form::date('date_debut', \Illuminate\Support\Facades\Config::get('stats.date_debut_analyse'), ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection

@section('date_fin')
{!! Form::date('date_fin', date('Y-m-d'), ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection

@section('donnees')
                {!! Form::label('enlevement','Enlèvement' ) !!}
                {!! Form::checkbox('enlevement', 'enlevement', true) !!}

                {!! Form::label('tonnage','Tonnage' ) !!}
                {!! Form::checkbox('tonnage', 'tonnage', true) !!}

                {!! Form::label('nc','NC' ) !!}
                {!! Form::checkbox('nc', 'nc', true) !!}

                {!! Form::label('ncagglo','NC Agglo' ) !!}
                {!! Form::checkbox('ncagglo', 'ncagglo', true) !!}
@endsection
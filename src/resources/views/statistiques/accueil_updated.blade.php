@extends('statistiques.accueil')

@section('flux')

@foreach ($fluxx as $flux)
            {!! Form::label('flux:'.strval($flux->id),$flux->type.' ('.$flux->societe.')' ) !!}
            {!! Form::checkbox('flux:'.strval($flux->id), 'flux:'.strval($flux->id),null,['class' => 'flux']) !!} 
        @endforeach 
@endsection

@section('dechetterie_p')
@foreach ($dechetteries as $dechetterie)
                {!! Form::label('dechetterie:'.strval($dechetterie->id),$dechetterie->nom ) !!}
                {!! Form::checkbox('dechetterie:'.strval($dechetterie->id), 'dechetterie:'.strval($dechetterie->id),null,['class' => 'dechetterie']) !!}

            @endforeach              
@endsection

@section('date_debut')
{!! Form::date('date_debut', null, ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection

@section('date_fin')
{!! Form::date('date_fin', null, ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection

@section('donnees')
                {!! Form::label('enlevement','Enlèvement' ) !!}
                {!! Form::checkbox('enlevement', 'enlevement') !!}

                {!! Form::label('tonnage','Tonnage' ) !!}
                {!! Form::checkbox('tonnage', 'tonnage') !!}

                {!! Form::label('nc','NC' ) !!}
                {!! Form::checkbox('nc', 'nc') !!}

                {!! Form::label('ncagglo','NC Agglo' ) !!}
                {!! Form::checkbox('ncagglo', 'ncagglo') !!}
@endsection


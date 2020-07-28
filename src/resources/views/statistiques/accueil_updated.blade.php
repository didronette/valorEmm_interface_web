@extends('statistiques.accueil')

@section('flux')

@foreach ($fluxx as $flux)
            {!! Form::label('flux:'.strval($flux->id),$flux->type ) !!}
            {!! Form::checkbox('flux:'.strval($flux->id), 'flux:'.strval($flux->id)) !!} 
        @endforeach 
@endsection

@section('dechetterie_p')
@foreach ($dechetteries as $dechetterie)
                {!! Form::label('dechetterie:'.strval($dechetterie->id),$dechetterie->nom ) !!}
                {!! Form::checkbox('dechetterie:'.strval($dechetterie->id), 'dechetterie:'.strval($dechetterie->id)) !!}

            @endforeach              
@endsection

@section('date_debut')
{!! Form::date('date_debut', null, ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection

@section('date_fin')
{!! Form::date('date_fin', null, ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection


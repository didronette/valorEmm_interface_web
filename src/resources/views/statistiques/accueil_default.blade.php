@extends('statistiques.accueil')

@section('flux')

@foreach ($fluxx as $flux)
            {!! Form::label('flux:'.strval($flux->id),$flux->type ) !!}
            {!! Form::checkbox('flux:'.strval($flux->id), 'flux:'.strval($flux->id),true) !!} 
        @endforeach 
@endsection

@section('dechetterie_p')
@foreach ($dechetteries as $dechetterie)
                {!! Form::label('dechetterie:'.strval($dechetterie->id),$dechetterie->nom ) !!}
                {!! Form::checkbox('dechetterie:'.strval($dechetterie->id), 'dechetterie:'.strval($dechetterie->id),true) !!}

            @endforeach              
@endsection

@section('date_debut')
{!! Form::date('date_debut', \Illuminate\Support\Facades\Config::get('stats.date_debut_analyse'), ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection

@section('date_fin')
{!! Form::date('date_fin', date('Y-m-d'), ['class' => 'form-control', 'placeholder' => 'Date de l\'enlècement']) !!}
@endsection


@extends('saisie/confirmation')


@section('titre')
    Confirmation de l'enlèvement
@endsection


@section('text')
    Information saisie concernant l'enlèvement : <br>
    <ul>
    <div>Date et heure de l'enlèvement : {!! $date_enlevement !!}</div>
    @if(isset($nc))
        <div>Vous avez saisi la non-conformité suivante : <br>{!! $nc  !!}</div>
    @endif
    
</ul>

    {!! Form::open(['route' => 'confirmerValidation']) !!}


@endsection

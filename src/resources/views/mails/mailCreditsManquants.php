@extends('mails/mail')

@section('nom')
    Thierry Stauder
@endsection

@section('content')
Vous manquer de crédit pour les appels et SMS : votre nombre actuel est de : {{$credits}}.
@endsection
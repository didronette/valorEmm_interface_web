@extends('saisie/nouvelleCommande/nouvelleCommande')

@section('nombre')
<p>Nombre de bennes :</p>
  <div>

{{ Form::label('multiplicite1', '1') }}
{{ Form::radio('multiplicite', '1', false, array('id'=>'multiplicite1')) }}


{{ Form::label('multiplicite2', '2') }}
{{ Form::radio('multiplicite', '2', false, array('id'=>'multiplicite2')) }}

{{ Form::label('multiplicite3', '3') }}
{{ Form::radio('multiplicite', '3', false, array('id'=>'multiplicite3')) }}

</div>
@endsection
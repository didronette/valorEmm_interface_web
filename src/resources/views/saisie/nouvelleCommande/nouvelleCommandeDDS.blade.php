@extends('saisie/nouvelleCommande/nouvelleCommande')

@section('nombre')
<p>Nombre de caisses :</p>
  <div>

{{ Form::label('multiplicite1', '1') }}
{{ Form::radio('multiplicite', '1', false, array('id'=>'multiplicite1')) }}

{{ Form::label('multiplicite2', '2') }}
{{ Form::radio('multiplicite', '2', false, array('id'=>'multiplicite2')) }}

{{ Form::label('multiplicite1', '3') }}
{{ Form::radio('multiplicite', '3', false, array('id'=>'multiplicite3')) }}

{{ Form::label('multiplicite1', '4') }}
{{ Form::radio('multiplicite', '4', false, array('id'=>'multiplicite4')) }}

{{ Form::label('multiplicite1', '5') }}
{{ Form::radio('multiplicite', '5', false, array('id'=>'multiplicite5')) }}

</div>



 
@endsection
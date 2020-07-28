@extends('saisie/modificationCommande/modificationCommande')

@section('nombre')
<p>Nombre de caisses :</p>
  <div>

{{ Form::label('multiplicite1', '1') }}
{{ Form::radio('multiplicite', '1', ($commande->multiplicite == 1), array('id'=>'multiplicite1')) }}

{{ Form::label('multiplicite2', '2') }}
{{ Form::radio('multiplicite', '2', ($commande->multiplicite == 2), array('id'=>'multiplicite2')) }}

{{ Form::label('multiplicite3', '3') }}
{{ Form::radio('multiplicite', '3', ($commande->multiplicite == 3), array('id'=>'multiplicite3')) }}

{{ Form::label('multiplicite4', '4') }}
{{ Form::radio('multiplicite', '4', ($commande->multiplicite == 4), array('id'=>'multiplicite4')) }}

{{ Form::label('multiplicite5', '5') }}
{{ Form::radio('multiplicite', '5', ($commande->multiplicite == 5), array('id'=>'multiplicite5')) }}

</div>
 
@endsection
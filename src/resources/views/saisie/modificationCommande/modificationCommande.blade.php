@extends('templatePage')

@section('titre')
    Modification de commande
@endsection


@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">
<div class="panel panel-primary" id="yellow">	
			<div class="panel-body" > 
				<div class="col-sm-12" >
                {!! Form::open(['route' => ['commandes.update', $commande->numero],'method' => 'put', 'class' => 'form-horizontal panel', 'id' => 'yellow-borderless']) !!}

                    @if(count($dechetteries) != 1)
                        <div class="form-group {!! $errors->has('dechetterie') ? 'has-error' : '' !!}">
                                {!! Form::select('dechetterie',$dechetteries,$commande->dechetterie ,['class' => 'form-control', 'placeholder' => 'Selection du flux']) !!}
                                {!! $errors->first('dechetterie', '<small class="help-block">:message</small>') !!}
                        </div>
                    @else
                        {!! Form::hidden('dechetterie', array_key_first($dechetteries)) !!}
		            @endif

                    {!! Form::hidden('numero', $commande->numero) !!}
                <div class="form-group {!! $errors->has('flux') ? 'has-error' : '' !!}">
                            {!! Form::select('flux',$fluxx, $commande->flux,['class' => 'form-control', 'placeholder' => 'Selection du flux']) !!}
                            {!! $errors->first('flux', '<small class="help-block">:message</small>') !!}
                    </div>

                    @yield('nombre')

                    {!! Form::submit('Modifier', ['class' => 'btn btn-block btn-success' ]) !!}



					{!! Form::close() !!}

                    {!! Form::open(['method' => 'DELETE', 'route' => ['commandes.destroy', $commande->numero]]) !!}
									{!! Form::submit('Supprimer', ['class' => 'btn btn-danger btn-block']) !!}
					{!! Form::close() !!}
				</div>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
        </div>
@endsection
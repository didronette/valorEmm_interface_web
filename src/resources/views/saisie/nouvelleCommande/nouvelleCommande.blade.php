@extends('templatePage')

@section('titre')
    Nouvelle Commande
@endsection


@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">
<div class="panel panel-primary">	
			<div class="panel-body" id="yellow-borderless"> 
				<div class="col-sm-12">
                {!! Form::open(['route' => 'commandes.store']) !!}

                    @if(count($dechetteries) != 1)
                        <div class="form-group {!! $errors->has('dechetterie') ? 'has-error' : '' !!}">
                                {!! Form::select('dechetterie',$dechetteries,null, ['class' => 'form-control', 'placeholder' => 'Selection de la déchetterie']) !!}
                                {!! $errors->first('dechetterie', '<small class="help-block">:message</small>') !!}
                        </div>
                    @else
                        {!! Form::hidden('dechetterie', array_key_first($dechetteries)) !!}
		            @endif

                <div class="form-group {!! $errors->has('flux') ? 'has-error' : '' !!}">
                            {!! Form::select('flux',$fluxx,null, ['class' => 'form-control', 'placeholder' => 'Selection du flux']) !!}
                            {!! $errors->first('flux', '<small class="help-block">:message</small>') !!}
                    </div>

                    @yield('nombre')

                    {!! Form::submit('Ajouter', ['class' => 'btn btn-block btn-success']) !!}
					{!! Form::close() !!}
				</div>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
        </div>
@endsection
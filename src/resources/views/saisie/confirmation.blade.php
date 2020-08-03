@extends('templatePage')

@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">

@if(session()->has('error'))
     		<div class="alert alert-danger">{{ session('error') }}</div>
			 <?php session()->forget('error');?>
@endif
<div class="panel panel-primary" id="yellow">	
			<div class="panel-body"> 
				<div class="col-sm-12">
                @yield('text')


                    @if(session()->has('dechetterie'))
                        <div class="form-group {!! $errors->has('pin') ? 'has-error' : '' !!}">
                                {!! Form::password('pin', ['class' => 'form-control', 'placeholder' => 'Code PIN']) !!}
                                {!! $errors->first('pin', '<small class="help-block">:message</small>') !!}
                        </div>
                    @else
                        {!! Form::hidden('pin', '0000') !!}

                   
		            @endif

                    {!! Form::submit('Confirmer', ['class' => 'btn btn-block btn-success']) !!}


					{!! Form::close() !!}
				</div>
            </div>
        </div>
		<a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
        </div>
@endsection
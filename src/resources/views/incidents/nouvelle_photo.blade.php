
@extends('templatePage')

@section('titre')
    Ajouter une photo
@endsection


@section('contenu')
<div class="col-sm-offset-5 col-sm-4 ">

@if(session()->has('sucess'))
     		<div class="alert alert-danger">{{ session('sucess') }}</div>
			 <?php session()->forget('sucess');?>
@endif
@if(session()->has('error'))
     		<div class="alert alert-danger">{{ session('error') }}</div>
			 <?php session()->forget('error');?>
		@endif

<div class="panel panel-primary">	
			<div class="panel-body" id="yellow-borderless"> 
				<div class="col-sm-12">
                

                    <form class="m-2" method="post" action="/incident/confirmation" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group {!! $errors->has('name') ? 'has-error' : '' !!}">
                            <label for="name">Nom du fichier</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter file Name" name="name">
                            {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
                        </div>
                        <div class="form-group {!! $errors->has('photo') ? 'has-error' : '' !!}">
                            <label for="image">Choisir l'image</label>
                            <input id="image" type="file" name="photo">
                            {!! $errors->first('photo', '<small class="help-block">:message</small>') !!}
                        </div>
                        {!! Form::submit('Ajouter', ['class' => 'btn btn-block btn-success']) !!}
                    </form>


				</div>
            </div>
        </div>
        <a href="javascript:history.back()" class="btn btn-success">
			<span class="glyphicon" style='font-size:25px;'>&#8634;</span>  Retour
		</a>
        </div>
@endsection


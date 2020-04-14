@extends ('layouts.admin')
@section ('contenido')
<script src="{{asset('sweetalert/sweetalert.min.js')}}"></script>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar sitio: {{ $sitio->Descripcion}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::model($sitio,['method'=>'PATCH','route'=>['sitio.update',$sitio->id]])!!}
            {{Form::token()}}
      
            <div class="form-group">
            	<label for="Descripcion">Nombre</label>
            	<input type="text" name="nombre" class="form-control" value="{{$sitio->nombre}}" placeholder="Descripción...">
			</div>
			
			<div class="form-group">
            	<label for="Descripcion">Url</label>
            	<input type="text" name="url" class="form-control" value="{{$sitio->url}}" placeholder="url...">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<a href="{{url('catalogo/sitio')}}"><button class="btn btn-danger" type="button">Cancelar</button></a>
            </div>

			{!!Form::close()!!}		
            
		</div>
		@include('sweet::alert')
	</div>
@endsection
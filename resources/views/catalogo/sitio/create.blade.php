@extends ('layouts.admin')
@section ('contenido')
<script src="{{asset('sweetalert/sweetalert.min.js')}}"></script>
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo sitio</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'catalogo/sitio','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
        
            <div class="form-group">
            	<label for="Descripcion">Nombre</label>
            	<input type="text" name="nombre" class="form-control" placeholder="Descripción...">
			</div>
			<div class="form-group">
            	<label for="Descripcion">Url</label>
            	<input type="text" name="url" class="form-control" placeholder="url...">
	    </div>
		<div class="form-group">
                <label for="Descripcion">Servidor</label>
                <input type="text" name="server" class="form-control" placeholder="Servidor Alojado">
	    </div>
		<div class="form-group">
                <label for="Descripcion">Ultimo Mantenimiento</label>
                <input type="date" name="mantenimiento" class="form-control" placeholder="Ultimo Mantenimiento">
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

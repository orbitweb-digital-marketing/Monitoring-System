@extends ('layouts.admin')
@section ('contenido')
<script src="{{asset('sweetalert/sweetalert.min.js')}}"></script>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Listado de sitios <a href="{{url('catalogo/sitio/create')}}"><button class="btn btn-success">Nuevo</button></a></h3>

	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<th>Id</th>
					<th>Nombre</th>
					<th>Url</th>
					<th>Servidor</th>
					<th>Ultimo Mantenimiento</th>
					<th>Opciones</th>
				</thead>
				@foreach ($sitios as $obj)
				<tr>
					<td>{{ $obj->id}}</td>
					<td>{{ $obj->nombre}}</td>
					<td>{{ $obj->url}}</td>
					<td>{{ $obj->server}}</td>
					<td>{{ $obj->maintenace}}</td>
					<td>
						<a href="{{URL::action('SitioController@edit',$obj->id)}}"><button class="btn btn-info">Editar</button></a>
						<a href="" data-target="#modal-delete-{{$obj->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
					</td>
				</tr>
				@include('catalogo.sitio.modal')
				@endforeach
			</table>
		</div>
		@include('sweet::alert')
	</div>
</div>

@endsection

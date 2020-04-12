@extends('Templates.main')
@section('content')
<!--<a href={{ route('urls.mail') }}>email</a>-->
<style>
    li{
        font-family: 'Montserrat'
    }
</style>
<table class="table table-sm">
    <thead>
        <tr>
            <th scope="col">Name of Site</th>
            <th scope="col">Url of Site</th>
            <th scope="col">Options</th>
        </tr>
    </thead>
    
    {{-- a foreach for print all sites in the BD --}}
    
    @foreach ($sitios as $sitio)
    <tr>
        
        <th scope="row"> {{$sitio->nombre}}</th>
        <th>{{$sitio->url }}</th>
        <th><button class="btn btn-danger">Delete</button>    <button onclick="edit_site({{$sitio->id}})" class="btn btn-primary">Edit</button></th>
        
    </tr>@endforeach
</table>    
<div id="editpopup">
    <form id="popup" action="" method="post">
        @csrf
        <input type="hidden" name="id">
        <input type="text" name="name" id="nameSite" placeholder="Name of Site">
        <input type="text" name="url" id="urlSite" placeholder="Url of Site">
    </form>
</div>
<form action="{{ route('urls.mail') }}" method="post">
    @csrf
    <input type="hidden" id="id" value="orbitweb" name="site">
    <button type="submit" class="primary">SEND</button>
</form>
@endsection
@section('scripts')
<script>
function edit_site(id){
    //alert(id);
    var div = document.getelementbyid("editpopup");
    div.style.display = 'block';
}
</script>
@endsection
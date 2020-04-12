@extends('Templates.main')
@section('content')
<!--<a href={{ route('urls.mail') }}>email</a>-->
<style>
    li{
        font-family: 'Montserrat'
    }
    #editpopup{
        display: none;
    }
    #insertpopup{
        display: none;
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
        <th><button class="btn btn-danger">Delete</button>    <button onclick="edit_site('{{$sitio->id}}','{{$sitio->nombre}}','{{$sitio->url}}')" class="btn btn-primary">Edit</button></th>
        
    </tr>@endforeach
</table>    
<div id="editpopup">
    <form id="popup" action={{route('url.store')}} method="post">
        @csrf
        <input type="hidden" name="id" id="id">
        <input type="text" name="name" id="nameSite" placeholder="Name of Site">
        <input type="text" name="url" id="urlSite" placeholder="Url of Site">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<div id="insertpopup">
    <form id="popup2" action="{{ route('url.create') }}" method="post">
        @csrf
        <input type="text" name="name" id="NameSite" placeholder="New Name of Site">
        <input type="text" name="url" id="UrlSite" placeholder="Url of Site">
        <button type="submit" class="btn btn-success">Insert</button>
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
function edit_site(id,name,url){
    //alert(id);
    var div = document.getElementById('editpopup');
    div.style.display = 'block';
    $('#nameSite').val(name);
    $('#urlSite').val(url);
    $('#id').val(id);
}

function insert_site(name,url){
    var div = document.getElementById('insertpopup');
    div.style.display = 'block';
    $('#NameSite').val(name);
    $('#UrlSite').val(url);

}
</script>
@endsection
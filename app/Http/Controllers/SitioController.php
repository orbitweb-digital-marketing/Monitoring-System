<?php

namespace monitor\Http\Controllers;

use Illuminate\Http\Request;

use monitor\Sitio;
use Illuminate\Support\Facades\Redirect;
use monitor\Http\Requests\SitioFormRequest;
use DB;

class SitioController extends Controller
{
    public function __construct()
    {
    }
    public function index(Request $request)
    {

        if ($request) {
            $sitios = DB::table('sitios')
                ->orderBy('id', 'asc')
                ->get();
            return view('catalogo.sitio.index', ["sitios" => $sitios]);
        }
    }
    public function create()
    {

        return view("catalogo.sitio.create");
    }
    public function store(SitioFormRequest $request)
    {
        $sitio = new Sitio;
        $sitio->nombre = $request->get('nombre');
        $sitio->url = $request->get('url');
        $sitio->save();

        alert()->success('El registro ha sido agregado correctamente');
        return Redirect::to('catalogo/sitio/create');
    }
    public function show($id)
    {
        return view("catalogo.sitio.show", ["sitio" => Sitio::findOrFail($id)]);
    }
    public function edit($id)
    {

        return view("catalogo.sitio.edit", ["sitio" => Sitio::findOrFail($id)]);
    }
    public function update(SitioFormRequest $request, $id)
    {
        $sitio = Sitio::findOrFail($id);
        $sitio->nombre = $request->get('nombre');
        $sitio->url = $request->get('url');
        $sitio->update();
        alert()->info('El registro ha sido modificado correctamente');
        return redirect('catalogo/sitio/' . $id . '/edit');
    }
    public function destroy($id)
    {
        $sitio = Sitio::findOrFail($id);
        $sitio->delete();
        alert()->error('El registro ha sido eliminado correctamente');
        return Redirect::to('catalogo/sitio');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitio;
use Mail;

class UrlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return 'ok';
        $sitios=Sitio::all();
        return view('Urlsviews.index',compact('sitios'));
    }

    function url_test( $url ) {
        $timeout = 10;
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_TIMEOUT, $timeout );
        $http_respond = curl_exec($ch);
        $http_respond = trim( strip_tags( $http_respond ) );
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
          return true;
        } else {
          // return $http_code;, possible too
          return false;
        }
        curl_close( $ch );
      }

    public function SendEmail(Request $request){
        //return $request;
        $to_name = 'OrbitWeb';
        $to_email = 'dev@orbitweb.ca';
        $data = array('name'=>'Zirok', 'body' => 'A test mail');
        Mail::send('Email.email', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Laravel Test Mail');
        $message->from('zirokguadron11@gmail.com','Test Mail');
        });
        
    }

    public function UpdateSite(Request $request){
        //return $request;
               $sitios=Sitio::find($request->id);
               //return $sitios;
               //$sitios->update([
                 //  'name' => $request -> nombre, 
                   //'url'=> $request-> url
               //]);
               $sitios->nombre = $request->name;
               $sitios->url = $request->url;
               $sitios->save(); 
               return back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $sitios = Sitio::create(['nombre'=> $request->name,
        'url'=> $request->url
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */                                                   
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
               
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    public function DeleteSite(Request $request){
        //return $request;
        $sitios=Sitio::find($request->id);
        $sitios->delete();
        return back();
    }
}
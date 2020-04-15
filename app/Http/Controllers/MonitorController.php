<?php

namespace monitor\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Mail;

class MonitorController extends Controller
{
    public function __construct()
    {
    }

    public function SendEmail(Request $request){
        //return $request;
        $to_name = 'OrbitWeb';
        $to_email = 'dev@orbitweb.ca';
        $data = array('name'=>'Zirok', 'body' => 'A test mail');
        Mail::send('Email.email', $data, function($message) use ($to_name, $to_email) {
        $message->to($to_email, $to_name)
        ->subject('Test Mail');
        $message->from('zirokguadron11@gmail.com','Test Mail');
        });
        //return 'joto';        
    }

    public function index(Request $request)
    {

        if ($request) {

            function url_test($url)
            {
                $timeout = 10;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                $http_respond = curl_exec($ch);
                $http_respond = trim(strip_tags($http_respond));
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if (($http_code == "200") || ($http_code == "302")) {
                    return true;
                } else {
                    // return $http_code;, possible too
                    return false;
                }
                curl_close($ch);
            }

            $query = DB::table('sitios')
                ->orderBy('id', 'asc')
                ->get();

            $i = 1;
            foreach ($query as $obj) {
                $sitios[$i][1] = $obj->nombre;
                $sitios[$i][2] = $obj->url;

                if (url_test($obj->url) == true)
                    $sitios[$i][3] = 1;
                else {
                    $sitios[$i][3] = 0;
                }
                $i++;
            }


            return view('monitor.index', ["sitios" => $sitios]);
        }
    }




    public function load()
    {

        function url_test($url)
        {
            $timeout = 10;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $http_respond = curl_exec($ch);
            $http_respond = trim(strip_tags($http_respond));
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (($http_code == "200") || ($http_code == "302")) {
                return true;
            } else {
                // return $http_code;, possible too
                return false;
            }
            curl_close($ch);
        }

        $query = DB::table('sitios')
            ->orderBy('id', 'asc')
            ->get();

        $i = 1;
        $offline =1;
        foreach ($query as $obj) {
            $sitios[$i][1] = $obj->nombre;
            $sitios[$i][2] = $obj->url;

            if (url_test($obj->url) == true)
                $sitios[$i][3] = '<button class="btn btn-success">on line</button>';
            else {
                $offline =0;
                $sitios[$i][3] = '<button class="btn btn-danger">off line</button>';
            }
            $i++;
        }

        //correo
        if( $offline ==0)
        {
            
        }


        echo ' <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Sistema</th>
                <th>URL</th>
                <th>Estado</th>
            </tr>
        </thead>
         <tbody>';
        for ($i = 1; $i <= count($sitios); $i++) {
            echo '<tr>
                <td align="center">' . $i . '</td>
                <td>' . $sitios[$i][1] . '</td>
                <td>' . $sitios[$i][2] . '</td>
                <td>' . $sitios[$i][3] . '</td>
            </tr> </tbody>';
        }
        echo '</table>';


        // return view("catalogo.sitio.index");
    }
}

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

    public function index(Request $request)
    {

        if ($request) {

            function url_test($url)
	    {
		    $timeout = 20;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                $http_respond = curl_exec($ch);
                $http_respond = trim(strip_tags($http_respond));
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if (($http_code == "200") || ($http_code == "302") || ($http_code == "301")) {
                    if ($http_code == "301") {
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
                        $http_respond = curl_exec($ch);
                        $http_respond = trim(strip_tags($http_respond));
                        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        if ($http_code == "301") {
                            return true;
                        }
                    }else{
                        return true;
                    }

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
		$sitios[$i][3] = $obj->server;
		$sitios[$i][4] = $obj->maintenace;

                if (url_test($obj->url) == true)
                    $sitios[$i][5] = 1;
                else {
                    $sitios[$i][5] = 0;
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
            $timeout = 20;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	    $http_respond = curl_exec($ch);
            $http_respond = trim(strip_tags($http_respond));
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (($http_code == "200") || ($http_code == "302") || ($http_code == "301")) {
                if ($http_code == "301"){
                    $http_respond = curl_exec($ch);
                    $http_respond = trim(strip_tags($http_respond));
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if (($http_code == "200") || ($http_code == "302") || ($http_code == "301")){
                         return true;
                     }
                }
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
	    $sitios[$i][3] = $obj->server;
	    $sitios[$i][4] = $obj->maintenace;
	$offline=5;
            if (url_test($obj->url) == true)
                $sitios[$i][5] = '<a href="" target="_blank"><button class="btn btn-success" type="button">Online</button></a>';
            else {
		    $sitios[$i][5] = '<a href="" target="_blank"><button class="btn btn-danger" type="nutton">Offline</button></a>';
		    //$sitios[$i][3] = '<button class="btn btn-danger">Offline</button>';
		    if($offline==5){
		    try{
                    $to_name = 'OrbitWeb';
                    $to_email = 'dev@orbitweb.ca';
                    $data = array('name'=> $obj->nombre , 'body' => 'Revisar ahora mismo!.');
                    $mail_status =  Mail::send('Email.email', $data, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                    ->subject('Monitoreo de Sitios');
                    $message->from('dev@orbitweb.ca','Monitoreo de Sitios');
                    });
                    //If error from Mail::send

                }
                catch(\Exception $e){
                     //Get error here
                   print $e->getMessage();
                    exit;
		}
		$offline=0;
		    }else{
			    $offline++;
		    }
	    }
            $i++;
	    
	}
        echo ' <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Sistema</th>
		<th>URL</th>
		<th>Servidor</th>
		<th>Mantenimiento</th>
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
		<td>' . $sitios[$i][4] . '</td>
		<td>' . $sitios[$i][5] . '</td>
            </tr> </tbody>';
        }
        echo '</table>';


        // return view("catalogo.sitio.index");
    }
    }

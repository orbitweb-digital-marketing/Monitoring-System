<?php

namespace monitor\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use DB;



class TestingCrom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Testing:crom';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing Crom commands';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
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

                if (url_test($obj->url) == true){
                    $sitios[$i][5] = 1;
   //                 $to_name = 'OrbitWeb';
     //               $to_email = 'brian@orbitweb.ca';
       //             $data = array('name'=>'allgood' , 'body' => 'fam.');
         //           $mail_status =  Mail::send('Email.email', $data, function($message) use ($to_name, $to_email) {
           //             $message->to($to_email, $to_name)
             //           ->subject('Monitoreo de Sitios');
               //         $message->from('infowowelsalvador@gmail.com','Monitoreo de Sitios');
                 //   });
                }
                else {
                    $to_name = 'OrbitWeb';
                    $to_email = 'brian@orbitweb.ca';
                    $data = array('name'=> $obj->nombre , 'body' => 'Revisar ahora mismo!.');
                    $mail_status =  Mail::send('Email.email', $data, function($message) use ($to_name, $to_email) {
                        $message->to($to_email, $to_name)
                        ->subject('Monitoreo de Sitios');
                        $message->from('dev@orbitweb.ca','Monitoreo de Sitios');
                    });
                }
                $i++;
            }

       
    }
}

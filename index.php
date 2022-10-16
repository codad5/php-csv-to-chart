<?php

require("vendor/autoload.php");

use Trulyao\PhpRouter\Router as Router;
use Trulyao\PhpRouter\HTTP\Response as Response;
use Trulyao\PhpRouter\HTTP\Request as Request;
use Trulyao\PhpStarter\Exceptions\HTTPException;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


$router = new Router(__DIR__ . "/src", "");

function getDataFromFile($filestream, $key = null){
    $json_array = [];
    while(($data = fgetcsv($filestream, 1000, ',')) != false){
        // var_dump($data);
        if(intval($data[0])){
            if($key == 'date'){
                $json_array[$data[1]] = [
                'rate' => $data[0],
                'date' => $data[1]
                ];
            }
            else{
                $json_array[] = [
                'rate' => $data[0],
                'date' => $data[1]
                ];
            }
            
        }
    }
    return $json_array;
}

$router->get("/", function (Request $request, Response $response) {
    $file = fopen('src/Mustard php backend developer  - Sheet1.csv', 'r');
    $rates_array = getDataFromFile($file, 'date');
    include_once __DIR__.'/src/views/index.php';
});


$router->get("/rates/:date", function (Request $request, Response $response) {
        $date = $request->params("date");
        $date = str_replace('%20', ' ',$date);// Removes special chars.

        $file = fopen('src/Mustard php backend developer  - Sheet1.csv', 'r');
        $rates_array = getDataFromFile($file, 'date');
        $today_rate = null;
        foreach($rates_array as $key => $value){
            if(strpos($key, trim($date)) !== false){
                $today_rate = $value['rate'];
            }
        }
        include_once __DIR__.'/src/views/index.php';


    
});
$router->get('/api/rates', function (Request $request, Response $response) {
    // $open = 
    
    
    $file = fopen('src/Mustard php backend developer  - Sheet1.csv', 'r');
    return $response->send([
            "message" => "Hello World",
            "status" => "success",
            "code" => 200,
            "data" => getDataFromFile($file)
        ]);
    

});
$router->get("/api/rates/:date", function (Request $request, Response $response) {
        $date = $request->params("date");
        $date = str_replace('%20', ' ',$date);// Removes special chars.

        $file = fopen('src/Mustard php backend developer  - Sheet1.csv', 'r');
        $file_data = getDataFromFile($file, 'date');
        $data = [];
        foreach($file_data as $key => $value){
            if(strpos($key, trim($date)) !== false){
                $data = $value;
            }
        }

        return $response->send([
            "message" => count($data) > 0 ? "Found Rate with date $date" : "Found No Rate with date $date",
            "status" => "success",
            "code" => 200,
            "data" =>  $data
        ]);
    
});

$router->get("/phpmyadmin", function (Request $request, Response $response) {
    return $response->redirect("http://localhost:2083");
});

$router->serve();

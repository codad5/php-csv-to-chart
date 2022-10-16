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
    $request->append("time", date('d M Y'));
    return $response->use_engine()->render("Views/index.html", $request);
});

$router->get('/rates', function (Request $request, Response $response) {
    // $open = 
    
    
    $file = fopen('src/Mustard php backend developer  - Sheet1.csv', 'r');
    return $response->send([
            "message" => "Hello World",
            "status" => "success",
            "code" => 200,
            "data" => getDataFromFile($file)
        ]);
    

});
$router->get("rates/:date", function (Request $request, Response $response) {
        $date = $request->params("date");
        $date = str_replace('%20', ' ',$date);// Removes special chars.

        $file = fopen('src/Mustard php backend developer  - Sheet1.csv', 'r');
        $data = getDataFromFile($file, 'date');
        echo $date;
        $data = $data[$date] ?? [];

        return $response->send([
            "message" => "Found Rate with date $date",
            "status" => "success",
            "code" => 200,
            "data" =>  $data
        ]);
    
});

$router->get("/phpmyadmin", function (Request $request, Response $response) {
    return $response->redirect("http://localhost:2083");
});

$router->serve();

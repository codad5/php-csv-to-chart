<?php

require("vendor/autoload.php");

use Trulyao\PhpRouter\Router as Router;
use Trulyao\PhpRouter\HTTP\Response as Response;
use Trulyao\PhpRouter\HTTP\Request as Request;
use Trulyao\PhpStarter\Exceptions\HTTPException;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


$router = new Router(__DIR__ . "/src", "");

function getDataFromFile($filestream){
    $json_array = [];
    while(($data = fgetcsv($filestream, 1000, ',')) != false){
        // var_dump($data);
        if(intval($data[0])){
            $json_array[] = [
                'rate' => $data[0],
                'date' => $data[1]
            ];
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
$router->get("json/:id", function (Request $request, Response $response) {
    try {
        $id = (int)$request->params("id");

        if (!$id) throw new HTTPException("Invalid ID provided!", 400);

        return $response->send([
            "message" => "Hello World",
            "status" => "success",
            "code" => 200,
            "data" => ["id" => $id]
        ]);
    } catch (HTTPException $e) {
        return $response->status($e->getCode())->send([
            "message" => $e->getMessage(),
            "status" => "error",
            "code" => $e->getCode(),
            "data" => []
        ]);
    } catch (Exception $e) {
        return $response->status(500)->send([
            "message" => "Internal Server Error",
            "status" => "error",
            "code" => 500,
            "data" => []
        ]);
    }
});

$router->get("/phpmyadmin", function (Request $request, Response $response) {
    return $response->redirect("http://localhost:2083");
});

$router->serve();

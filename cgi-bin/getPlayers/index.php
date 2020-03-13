<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');

header("Access-Control-Allow-Headers: Content-Type, Authorization");

require '../../vendor/autoload.php';


$app = new \Slim\App;

$app->get('/getPlayers', function (Request $request, Response $response, array $args) {
    require './DBSettings.php';
    require './PreparedStatements.php';
    //$name = $args['name'];

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dataBaseName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connectionMessage =  "Connected successfully";
        $statement = $conn->prepare($getAllPlayers);
        $statement->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $arr[] = $row;
        }
        $connectionMessage = var_export($arr);
        $conn = null;
    }
    catch(PDOException $e)
    {
        $connectionMessage = "Connection failed: " . $e->getMessage();
    }

    $response->getBody()->write($connectionMessage);
    return $response;
});

$app->run();
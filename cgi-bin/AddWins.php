<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');

header("Access-Control-Allow-Headers: Content-Type, Authorization");

require '../vendor/autoload.php';


$app = new \Slim\App;

$app->get('/addWins', function (Request $request, Response $response, array $args) {
    require './DBSettings.php';
    require './PreparedStatments.php';
    $player1Id = $args['player1'];
    $player2Id = $args['player2'];
    $player1Score = $args['player1Score'];
    $player2Score = $args['player2Score'];
    $date = $args['date'];

    function getPlayerAndUpdateScore(playerId, score, date, conn) {

        //GET PLAYER'S INFO
        $statement = $conn->prepare($getPlayerInfo);
        $statement->execute([
            'playerId' => playerId
        ]);
        $arr = $statement->fetch();
        list($wins, $losses) = $arr;

        if(score) {
            $wins += score;
        }else {
            $losses += 1;
        }

        //UPDATE THEIR CURRENT WINS AND LOSSES
        $statement = conn->prepare($updatePlayer);
        $statement->execute([
            'id' => $id
        ]);

        //INSERT NEW DAILY WINS OR LOSSES
        $statement = conn->prepare($insertDailyWins);
        $statement->execute([
            'win' => $win,
            'loss' => $loss,
            'date' => date
        ]);

        //GET THE LAST DAILY ID THAT WAS CREATED
        $statement = conn->prepare($getMaxDailyId);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_COLUMN);
        list($dailyId) = $arr;

        //TIE DAILY AND PLAYER IN PLAYER_TO_DAILY_WINS
        $statement = conn->prepare($insertPlayerToDaily);
        $statement->execute([
            'daily_id' => $dailyId
        ]);
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dataBaseName", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //$connectionMessage =  "Connected successfully";
        
        $statement = $conn->prepare($getPlayerInfo);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_COLUMN);
        list($wins, $losses) = $arr;

        $connectionMessage = 'wins ' . $wins . ' losses ' . $losses;
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
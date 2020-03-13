<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use Slim\Factory\AppFactory;

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD');

header("Access-Control-Allow-Headers: Content-Type, Authorization");

require '../vendor/autoload.php';


$app = new \Slim\App;

$app->get('/hello', function (Request $request, Response $response, array $args) {
    require './DBSettings.php';
    require './PreparedStatements.php';
    //$name = $args['name'];

    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dataBaseName", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connectionMessage =  "Connected successfully";

        /*$statement = $conn->prepare('INSERT INTO players (first_name, wins, loss) VALUES (:fname, :win, :loss)');

        $status = $statement->execute([
            'fname' => 'katy',
            'win' => '0',
            'loss' => '0',
        ]);*/
        $statement = $conn->prepare($getPlayerInfo);
        $statement->execute([
            'playerId' => '1'
        ]);
        $arr = $statement->fetch();
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

$app->get('/getAllPlayers', function (Request $request, Response $response, array $args) {
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
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $arr[] = $row;
        }
        $connectionMessage = json_encode($arr);
        $conn = null;
    }
    catch(PDOException $e)
    {
        $connectionMessage = "Connection failed: " . $e->getMessage();
    }

    $response->getBody()->write($connectionMessage);
    return $response;
});

$app->post('/addScores', function (Request $request, Response $response) {
    require './DBSettings.php';
    
    $data = $request->getParsedBody();
    $player1Id = filter_var($data['player1'], FILTER_SANITIZE_NUMBER_INT);
    $player1Score = filter_var($data['player1Score'], FILTER_SANITIZE_NUMBER_INT);
    $player2Id = filter_var($data['player2'], FILTER_SANITIZE_NUMBER_INT);
    $player2Score = filter_var($data['player2Score'], FILTER_SANITIZE_NUMBER_INT);
    $date = date("Y/m/d");
    $statusCode = '500';

    function getPlayerAndUpdateScore($playerId, $opponentId, $score, $date, $conn) {
        require './PreparedStatements.php';
        $updatePlayerStatus = false;
        //GET PLAYER'S INFO
        $statement = $conn->prepare($getPlayerInfo);
        $response = $statement->execute([
            'playerId' => $playerId
        ]);

        if($response) {
            $arr = $statement->fetch();
            list($wins, $losses) = $arr;

            if($score) {
                $wins += $score;
            }else {
                $losses += 1;
            }
            $updatePlayerStatus = true;
        }else {
            $updatePlayerStatus = false;
        }
        
        if($updatePlayerStatus) {
            //UPDATE THEIR CURRENT WINS AND LOSSES
            $statement = $conn->prepare($updatePlayer);
            $response = $statement->execute([
                'id' => $playerId,
                'win' => $wins,
                'loss' => $losses
            ]);

            if($response) {
                $updatePlayerStatus = true;
            }else {
                $updatePlayerStatus = false;
            }

            if($updatePlayerStatus) {
                //INSERT NEW DAILY WINS OR LOSSES
                $statement = $conn->prepare($insertDailyWins);
                if($score) {
                    $playerWin = 1;
                    $playerloss = 0;
                }else {
                    $playerWin = 0;
                    $playerloss = 1;
                }
                $response = $statement->execute([
                    'win' => $playerWin,
                    'loss' => $playerloss,
                    'opponentId' => $opponentId,
                    'date' => $date
                ]);

                if($response) {
                    $updatePlayerStatus = true;
                }else {
                    $updatePlayerStatus = false;
                }

                if($updatePlayerStatus) {
                    //GET THE LAST DAILY ID THAT WAS CREATED
                    $statement = $conn->prepare($getMaxDailyId);
                    $response = $statement->execute();
                    $arr = $statement->fetchAll(PDO::FETCH_COLUMN);
                    list($dailyId) = $arr;

                    if($response) {
                        $updatePlayerStatus = true;
                    }else {
                        $updatePlayerStatus = false;
                    }

                    if($updatePlayerStatus) {
                        //TIE DAILY AND PLAYER IN PLAYER_TO_DAILY_WINS
                        $statement = $conn->prepare($insertPlayerToDaily);
                        $response = $statement->execute([
                            'playerId' => $playerId,
                            'dailyId' => $dailyId
                        ]);

                        if($response) {
                            $updatePlayerStatus = true;
                        }else {
                            $updatePlayerStatus = false;
                        }
                    }
                }
            }
            
        }

        return $updatePlayerStatus;
    }

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dataBaseName", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $status = getPlayerAndUpdateScore($player1Id, $player2Id, $player1Score, $date, $conn);
        $status = getPlayerAndUpdateScore($player2Id, $player1Id, $player2Score, $date, $conn);
        if($status) {
        $statusCode = $response->getStatusCode();
        }else {
            $statusCode = $response->withStatus(500);
        }
        $conn = null;
    }
    catch(PDOException $e)
    {
        $statusCode = "Connection failed: " . $e->getMessage();
    }

    
    
    $response->getBody()->write($statusCode);
    return $response;
});

$app->run();
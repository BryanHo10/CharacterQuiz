<?php 
/**
 * Router file for API endpoints
 * 
 * Each endpoint has a corresponding php file located in ./api/v1/...
 */


include_once('config/init.php');
header('Content-Type: application/json');

// if (basename($_SERVER['PHP_SELF']) == 'api.php') {
//     die(APP_TITLE.' API v'.API_VERSION);
// }

$reqType = $_SERVER['REQUEST_METHOD'];

// Get the version requested
if ($_GET['v'] == '1') {
    
    // Accepted Requests
    // TODO: Maybe move the accepted request types to each API endpoint and check array here
    if ($reqType == 'GET' || $reqType == 'POST' || $reqType == 'PUT') {
        if (!file_exists('api/v1/'.$_GET['request'].'.php')) {
            http_response_code(400);
            die('{"status":"404","errors":["Unknown Endpoint"]}');
        }

        if (isset($_GET['request'])) {
            include_once('api/v1/'.$_GET['request'].'.php');
            
            $inputData = json_decode(file_get_contents('php://input'));
            $endpoint = new Endpoint;
            $res = $endpoint->getResponse($reqType, $inputData);

            if (empty($endpoint->errors())) {
                echo json_encode($res);
            } else {
                http_response_code(400);
                die('{"status":"400","errors":'.json_encode($endpoint->errors()).'}');
            }
        } else {
            http_response_code(400);
            die('{"status":"400","errors":["Required parameters not given"]}');
        }
    } else {
        http_response_code(400);
        die('{"status":"405","errors":["Request Type not supported!"]}');
    }
} else {
    http_response_code(400);
    die('{"status":"400","errors":["Required parameters not given"]}');
}
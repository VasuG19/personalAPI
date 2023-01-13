<?php
include "config/config.php";

// Headers added here.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
    exit(0);
}

define('SECRET', ">4!F.oZ&}D8|gtX+U-~O@)8=KL>!?w");

//Base Endpoint
if (!in_array($_SERVER['REQUEST_METHOD'], array("GET"))){
    http_response_code(405);
    $response['message'] = "Invalid method: ". $_SERVER['REQUEST_METHOD'];
} 

$path = parse_url($_SERVER['REQUEST_URI'])['path'];
$path = str_replace("coursework/app/", "", $path);

switch($path){

    case'/':
        $endpoint = new Base();
    break;

    case '/papers':
    case '/paper':
    case '/papers/':
    case '/paper/':
        $endpoint = new Papers();
    break;

    case '/authors':
    case '/author':
    case '/authors/':
    case '/author/':
        $endpoint = new Authors();
    break;

    case '/affiliations':
    case '/affiliation':
    case '/affiliations/':
    case '/affiliation/':
        $endpoint = new Affiliation();
    break;

    case '/auth':
    case '/authenticate':
    case '/auth/':
    case '/authenticate/':
        $endpoint = new Authenticate();
    break;

    case '/update':
    case '/update/':
        $endpoint = new Update();
    break;

    default:
       $endpoint = new ClientError("Path not found: " . $path, 404);
}

$response = $endpoint->getData();
echo json_encode($response);

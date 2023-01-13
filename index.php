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

    case '/coursework/app/papers':
    case '/coursework/app/paper':
    case '/coursework/app/papers/':
    case '/coursework/app/paper/':
        $endpoint = new Papers();
    break;

    case '/coursework/app/authors':
    case '/coursework/app/author':
    case '/coursework/app/authors/':
    case '/coursework/app/author/':
        $endpoint = new Authors();
    break;

    case '/coursework/app/affiliations':
    case '/coursework/app/affiliation':
    case '/coursework/app/affiliations/':
    case '/coursework/app/affiliation/':
        $endpoint = new Affiliation();
    break;

    case '/coursework/app/auth':
    case '/coursework/app/authenticate':
    case '/coursework/app/auth/':
    case '/coursework/app/authenticate/':
        $endpoint = new Authenticate();
    break;

    case '/coursework/app/update':
    case '/coursework/app/update/':
        $endpoint = new Update();
    break;

    default:
       $endpoint = new ClientError("Path not found: " . $path, 404);
}

$response = $endpoint->getData();
echo json_encode($response);

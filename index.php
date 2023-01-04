<?php
include "config/config.php";

// Headers added here.
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
http_response_code(200);

//Base Endpoint
if (!in_array($_SERVER['REQUEST_METHOD'], array("GET"))){
    http_response_code(405);
    $response['message'] = "Invalid method: ". $_SERVER['REQUEST_METHOD'];
} 

$url = parse_url($_SERVER["REQUEST_URI"]);
$path = $url['path'];

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
    case '/coursework/app/authentiaction':
        $endpoint = new Authentiaction();
    break;

    default:
     //   $endpoint = new ClientError("Path not found: " . $path, 404);
        
}

$response = $endpoint->getData();
echo $response;
?>

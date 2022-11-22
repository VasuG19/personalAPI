<?php
include "src/database.php";
include "src/papers.php";

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
    case '/coursework/app/papers':
        $papers = new Papers();
        $json = $papers->getData();
    break;

    default:
    $json = json_encode(array(
    "first_name" => "Mehtab",
    "last_name" => "Gill",
    "id" => "w20019386",
    "conference name" => "chiplay",
    "documentation" => "tbd"
    ));
}

echo $json
?>

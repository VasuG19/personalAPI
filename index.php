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

    case '/coursework/app/papers':
    case '/coursework/app/paper':
    case '/coursework/app/papers/':
    case '/coursework/app/paper/':
        $papers = new Papers();
        $json = $papers->getData();
    break;

    case '/coursework/app/authors':
    case '/coursework/app/author':
    case '/coursework/app/authors/':
    case '/coursework/app/author/':
        $authors = new Authors();
        $json = $authors->getData();
    break;

    case '/coursework/app/pages':
    case '/coursework/app/page':
    case '/coursework/app/pages/':
    case '/coursework/app/page/':
        $page = new Page();
        $json = $page->getData();
    break;

         http_response_code(404);
        $data = array("Message"=>"Endpoint ".$path." not found");
        $data = json_encode($data);
    default:
        $base = new Base();
        $json = $base->getData();
    break;
        
}

echo $json
?>

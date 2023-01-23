<?php
include "config/config.php";

/**
 * Base file from which all information will be accessed
 *  
 * @author Mehtab Gill
 */

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
    exit(0);
}

//Base Endpoint
if (!in_array($_SERVER['REQUEST_METHOD'], array("GET"))){
    http_response_code(405);
    $response['message'] = "Invalid method: ". $_SERVER['REQUEST_METHOD'];
} 

$path = parse_url($_SERVER['REQUEST_URI'])['path'];
$path = str_replace("coursework/app/", "", $path);

// switch statement to route the API to the correct endpoints
try {
    switch($path){
        case'/':
            $endpoint = new Base();
        break;
        case '/papers':
        case '/papers/':
            $endpoint = new Papers();
        break;
        case '/authors':
        case '/authors/':
            $endpoint = new Authors();
        break;
        case '/affiliation':
        case '/affiliation/':
            $endpoint = new Affiliation();
        break;
        case '/auth':
        case '/auth/':
            $endpoint = new Authenticate();
        break;
        case '/update':
        case '/update/':
            $endpoint = new Update();
        break;
        default:
        $endpoint = new ClientError("Path not found: " . $path, 404);
    }
}
catch(ClientErrorException $e) {
    $endpoint = new ClientError($e->getMessage(), $e->getCode());
}

$response = $endpoint->getData();
echo json_encode($response);

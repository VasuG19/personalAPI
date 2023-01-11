<?php

use FirebaseJWT\JWT;
use FirebaseJWT\Key;

class Update extends Endpoint
{
    public function __construct(){
    $this->validateRequestMethod("POST");
    $this->validateToken();
    $this->validateUpdateParams();
    
    $db = new Database("db/films.sqlite");
    $this->initialiseSQL();
    $queryResult = $db->executeSQL($this->getSQL(), $this->getSQLParams());

    $this->setData( array(
            "length" => 0,
            "message" => "success",
            "data" => null
        ));
    }

    private function validateRequestMethod($method) {
    if ($_SERVER['REQUEST_METHOD'] != $method) {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }
    }
    private function validateToken() {
        // 1. Use the secret key
        $key = SECRET;
                
        // Get all headers from the http request
        $allHeaders = getallheaders();
        $authorizationHeader = "";
                
        // 3. Look for an Authorization header. This 
        // this might not exist. It might start with a capital A (requests
        // from Postman do), or a lowercase a (requests from browsers might)
        if (array_key_exists('Authorization', $allHeaders)) {
            $authorizationHeader = $allHeaders['Authorization'];
        } elseif (array_key_exists('authorization', $allHeaders)) {
            $authorizationHeader = $allHeaders['authorization'];
        }
                
        // 4. Check if there is a Bearer token in the header
        if (substr($authorizationHeader, 0, 7) != 'Bearer ') {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }

        // 5. Extract the JWT from the header (by cutting the text 'Bearer ')
        $jwt = trim(substr($authorizationHeader, 7));

        // 6. Use the JWT class to decode the token
        try {
        // 6. Use the JWT class to decode the token
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Exception $e) {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }

        if ($decoded->iss != $_SERVER['HTTP_HOST']) {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }
    }

    private function validateUpdateParams() {
 
        // 1. Look for a language and film_id parameter
        if (!filter_has_var(INPUT_POST,'language')) {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }
        if (!filter_has_var(INPUT_POST,'film_id')) {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }
            
        // 2. Check to see if a valid language is supplied 
        $languages = ["english", "french", "german", "italian", "japanese", "mandarin"];
        if (!in_array(strtolower($_POST['language']), $languages)) {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }
    }

    protected function initialiseSQL() {
        $language_ids = ["english"=>1,"french"=>3,"german"=>6,"italian"=>2,"japanese"=>4, "mandarin"=>5];
        
        $lang_id = $language_ids[strtolower($_POST['language'])];
        
        $sql = "UPDATE film SET language_id = :language_id WHERE film_id = :film_id";
        $this->setSQL($sql);
        $this->setSQLParams(['language_id'=> $lang_id, 'film_id'=>$_POST['film_id']]);
    }
}
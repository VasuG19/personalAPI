<?php

use FirebaseJWT\JWT;
use FirebaseJWT\Key;

class Update extends Endpoint
{
    public function __construct(){
        
        $db = new Database("db/films.sqlite");
        $this->validateRequestMethod("POST");
        $this->validateToken();
        $this->validateUpdateParams();
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
        
        $key = SECRET;
        $allHeaders = getallheaders();
        $authorizationHeader = "";
                
        if (array_key_exists('Authorization', $allHeaders)) {
            $authorizationHeader = $allHeaders['Authorization'];
        } elseif (array_key_exists('authorization', $allHeaders)) {
            $authorizationHeader = $allHeaders['authorization'];
        }
                
        if (substr($authorizationHeader, 0, 7) != 'Bearer ') {
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }

        $jwt = trim(substr($authorizationHeader, 7));

        try {
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
        if (!filter_has_var(INPUT_POST,'award')) {
            die( json_encode( array(
                "message" => "award parameter required"
            )));
        }
        if (!filter_has_var(INPUT_POST,'paper_id')) {
            die( json_encode( array(
                "message" => "paper_id parameter required"
            )));
        }
        $award_status = ["true", ""];
        if (!in_array(strtolower($_POST['award']), $award_status)) {
            die( json_encode( array(
                "message" => "invalid award status"
            )));
        }
    }

    protected function initialiseSQL() {
        $award_ids = ["true"=>1,""=>0];
        $award = $award_ids[strtolower($_POST['award'])];
        $sql = "UPDATE paper SET award = :award WHERE paper_id = :paper_id";
        $this->setSQL($sql);
        $this->setSQLParams(['award'=> $award, 'paper_id'=>$_POST['paper_id']]);
    }
}
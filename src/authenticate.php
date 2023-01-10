<?php
class Authenticate extends Endpoint
{
  public function __construct() {
        $db = new Database("db/chiplay.sqlite");
        $this->validateRequestMethod("POST");
        $this->validateAuthParameters();
        $this->initialiseSQL();
        $queryResult = $db->executeSQL($this->getSQL(), $this->getSQLParams());
        $this->validateUsername($queryResult);
        $this->validatePassword($queryResult); 

        http_response_code(503);

        $this->setData( array(
          "length" => 0,
          "message" => "endpoint under construction",
          "data" => null
        ));
    }

    private function validateRequestMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] != $method){
            die( json_encode( array(
                "message" => "invalid request method"
            )));
        }
    }

     private function validateAuthParameters() {
        if ( !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
            die( json_encode( array(
                "message" => "username and password required"
            )));
        }
    }

    private function validateUsername($data) {
        if (count($data)<1) {
            die( json_encode( array(
                "message" => "invalid credentials"
            )));
        }
    }

    private function validatePassword($data) {
        if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
            die( json_encode( array(
                "message" => "invalid credentials"
            )));
        }
    }

    protected function initialiseSQL() {
        $sql = "SELECT *
                FROM account
                WHERE account.username = :username";
        $this->setSQL($sql);
    $this->setSQLParams(['username' => $_SERVER['PHP_AUTH_USER']]);
    }


}

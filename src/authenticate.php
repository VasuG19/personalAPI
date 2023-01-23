<?php

/**
 *  Authenticate endpoint
 * 
 * Endpoint for the Admin page, encrypts the 
 * username and password entered from the web
 * app to verify against the login credentials 
 * in the database using the Firebase back-end 
 * service
 *
 * @author Mehtab Gill
 */
use FirebaseJWT\JWT;
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
        
        $data['token'] = $this->createJWT($queryResult);

        $this->setData( array(
          "length" => 0,
          "message" => "success",
          "data" => $data
        ));
    }

    private function validateRequestMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] != $method){
           throw new ClientErrorException("invalid request method", 405);
        }
    }

     private function validateAuthParameters() {
        if ( !isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ) {
            throw new ClientErrorException("username and password required", 401);
        }
    }

    private function validateUsername($data) {
        if (count($data)<1) {
           throw new ClientErrorException("invalid credentials", 401);
        }
    }

    private function validatePassword($data) {
        if (!password_verify($_SERVER['PHP_AUTH_PW'], $data[0]['password'])) {
            throw new ClientErrorException("invalid credentials", 401);
        }
    }

    protected function initialiseSQL() {
        $sql = "SELECT *
                FROM account
                WHERE account.username = :username";
        $this->setSQL($sql);
    $this->setSQLParams(['username' => $_SERVER['PHP_AUTH_USER']]);
    }

    private function createJWT($queryResult) {
    $time = time();
    // 1. Uses the secret key defined earlier
    $secretKey =SECRET;

    // 2. Specify what to add to the token payload. 
    $tokenPayload = [
        'iat' => $time,
        'exp' => strtotime('+1 day', $time),
        'iss' => $_SERVER['HTTP_HOST'],
        'account_id' => $queryResult[0]['account_id'],
        'username' => $queryResult[0]['username'],
        'name' => $queryResult[0]['name'],
    ];
        
    // 3. Use the JWT class to encode the token  
    $jwt = JWT::encode($tokenPayload, $secretKey, 'HS256');
    return $jwt;
    }


}

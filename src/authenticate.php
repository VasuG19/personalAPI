<?php
class Authenticate extends Endpoint
{
  public function __construct() {

        http_response_code(503);

        $this->setData( array(
          "length" => 0,
          "message" => "endpoint under construction",
          "data" => null
        ));
    }


}

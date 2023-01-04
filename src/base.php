<?php
class Base extends Endpoint {
    public function __construct() {
        $data = array(
            "name" => "First Last",
            "id" => "w123456789",
        );
        $this->setData( array(
            "length" => count($data),
            "message" => "Success",
            "data" => $data
        ));
    }
}
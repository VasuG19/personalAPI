<?php
class Base extends Endpoint {

    private $sql;
    private $sqlParams;


    public function __construct()
    {
        $name = array(
            "first_name" => "Mehtab",
            "last_name" => "Gill",
        );
        $db = new Database("db/chiplay.sqlite");
        $this->initialiseSQL();
        $data = $db->executeSQL($this->sql, $this->sqlParams);
        $this->setData( array(
            "length" => count($data),
            "message" => "Success",
            "name" => $name,
            "id" => "w123456789",
            "conference name" => $data
        ));

    }

     public function initialiseSQL(){

        $sql = "SELECT conference_information.name 
                FROM conference_information ";
        $this->setSQL($sql);

    }

    
}
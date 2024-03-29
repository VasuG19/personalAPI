<?php
/**
 *  Base endpoint
 * 
 * The base endpoint is the standard endpoint 
 * before any data is recieved
 * 
 * this is not used by the web app
 *  
 * @author Mehtab Gill
 */
class Base extends Endpoint {
    public function __construct()
    {
        $db = new Database("db/chiplay.sqlite");
        $sql = "SELECT conference_information.name 
                FROM conference_information ";
        $data = $db->executeSQL($sql);

        $name = array(
            "first_name" => "Mehtab",
            "last_name" => "Gill",
        );

        $base = array(
            "name" => $name,
            "id" => "w123456789",
            "link to documentation: " => "",
            "conference" => $data);
        
        $this->setData( array(
            "length" => count($base),
            "message" => "Success",
            "data" => $base,
        ));

    }
    
}
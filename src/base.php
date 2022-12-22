<?php
class Base {
    private $data;

     public function __construct() {


        $chi_play = new Database("db/chiplay.sqlite");
        $sql = "SELECT conference_information.name
                FROM conference_information 
                ";

        $name = array(
            "first_name" => "Mehtab",
            "last_name" => "Gill",
        );

        $documentation = "tbd";

        $conference = $chi_play->executeSQL($sql);

        $data = array(
            "name" => $name,
            "id" => "W20019386",
            "link to documentation: " => $documentation,
            "conference" => $conference
        );

        $this->data = $data;
    }


     public function getData() {
        return json_encode($this->data);
    }

}
?>
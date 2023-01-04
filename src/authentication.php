<?php
class Authentiaction
{
    private $data;

     public function __construct() {
        $chi_play = new Database("db/chiplay.sqlite");
        $sql = "SELECT paper.paper_id,
                        paper.track_id,
                        paper.title,
                        paper.award,
                        paper.abstract,
						track.track_id,
                        track.name,
                        track.short_name 
                    FROM paper 
                    Join track
					ON paper.track_id = track.track_id";
        $params = array();   

                    if(filter_has_var(INPUT_GET, 'track')){
                         $sql .= " WHERE track.short_name = :track";
                         $params['track'] = $_GET['track'];

                    }

                    $this->data = $chi_play->executeSQL($sql, $params);
    }


     public function getData() {
        return json_encode($this->data);
    }

}
?>
<?php
class Papers
{
    private $data;

     public function __construct() {
        $chi_play = new Database("db/chiplay.sqlite");
           $this->data = $chi_play->executeSQL("SELECT paper.paper_id,
                        paper.track_id,
                        paper.title,
                        paper.award,
                        paper.abstract,
                        track.name,
                        track.short_name 
                    FROM paper 
                    Join track");
    }


     public function getData() {
        return json_encode($this->data);
    }

}
?>
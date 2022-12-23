<?php
class Page
{
    private $data;

     public function __construct() {
        $chi_play = new Database("db/chiplay.sqlite");
        $sql = "SELECT  author.author_id,
                        author.first_name,
                        author.middle_initial,
                        author.last_name,

                        affiliation.author_id,
                        affiliation.paper_id,
						affiliation.institution,
                        affiliation.country,

                        paper.title,
                        paper.abstract,
                        paper.paper_id,
						paper.award,
						paper.track_id,
						
						track.track_id,
						track.short_name

                FROM author 
                join affiliation
                on author.author_id = affiliation.author_id
                join paper
                on  paper.paper_id = affiliation.paper_id
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
<?php
class Affiliation extends Endpoint
{
     public function initialiseSQL() {
        $sql = "SELECT	affiliation.author_id,
                        affiliation.paper_id,
			affiliation.institution,
                        affiliation.country
                FROM affiliation";
        $params = [];   

        if(filter_has_var(INPUT_GET, 'paper_id')){
                $sql .= " WHERE affiliation.paper_id = :paper_id";
                $params['paper_id'] = $_GET['paper_id'];

        }

        if(filter_has_var(INPUT_GET, 'author_id')){
                $sql .= " WHERE affiliation.author_id = :author_id";
                $params['author_id'] = $_GET['author_id'];

        }

        $this->setSQL($sql);
        $this->setSQLParams($params);

    }
}
?>
<?php
class Authors extends Endpoint
{
    protected function initialiseSQL()
     { 
        $sql = "SELECT author.author_id,
                        author.first_name,
                        author.middle_initial,
                        author.last_name,
                        paper_has_author.author_id,
                        paper_has_author.id,
                        paper_has_author.paper_id,
                        paper.paper_id
                FROM author 
                join paper_has_author
                on author.author_id = paper_has_author.author_id
                join paper
                on  paper.paper_id = paper_has_author.paper_id";
        $params = [];  

        if(filter_has_var(INPUT_GET, 'paper_id')){
                $sql .= " WHERE paper_has_author.paper_id = :paper_id";
                $params['paper_id'] = $_GET['paper_id'];

        }

        $this->setSQL($sql);
        $this->setSQLParams($params);
    }

}
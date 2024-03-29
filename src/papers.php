<?php

/**
 * Papers endpoint
 * 
 * selects call papers and paper data from the database
 * 
 * also selects data from the track table for the corresponding
 * paper using the paper and track _ID's 
 * 
 * @author Mehtab Gill
 */
class Papers extends Endpoint
{
     protected function initialiseSQL()
     {       
        $sql = "SELECT paper.paper_id,
                       paper.track_id,
                       paper.title,
                       coalesce(award, 'false') award,
                       paper.abstract,
                       track.track_id,
                       track.name,
                       track.short_name 
                FROM paper 
                Join track
				ON paper.track_id = track.track_id";
        $params = [];   

        if(filter_has_var(INPUT_GET, 'track')){
                $sql .= " WHERE track.short_name = :track";
                $params['track'] = $_GET['track'];

        }

        $this->setSQL($sql);
        $this->setSQLParams($params);
    }
}
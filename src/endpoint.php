<?php

abstract class Endpoint extends Database
{
    private $data;
    private $sql;
    private $sqlParams;

    public function __construct() {
        $db = new Database("db/chiplay.sqlite");
        $this->initialiseSQL();
        $data = $db->executeSQL($this->sql, $this->sqlParams);
        $this->setData(array(
            "length" => count($data),
            "message" => "Success",
            "data" => $data
        ));
    }
    protected function setSQL($sql) {
        $this->sql = $sql;
    }
    protected function getSQL() {
        return $this->sql;
    }
    protected function setSQLParams($params) {
        $this->sqlParams = $params;
    }
    protected function getSQLParams() {
        return $this->sqlParams;
    }
    protected function initialiseSQL() {
        $sql = "";
        $this->setSQL($sql);
        $this->setSQLParams([]);
    }
    protected function setData($data) {
        $this->data = $data;
    }
    public function getData() {
        return $this->data;
    }
}
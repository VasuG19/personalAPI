<?php
class Database
{
    //locate database
    private $dbConnection;
    public function __construct($dbName = "chiplay.sqlite")
    {
        $this->setDbConnection($dbName);
    }

    // create connection to database
    private function setDbConnection($dbName) {        
        $this->dbConnection = new PDO('sqlite:'.$dbName);
        $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function executeSQL($sql, $params=[]) {
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
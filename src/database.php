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
    private function setDbConnection($dbName)
    {
        try {
            $this->dbConnection = new PDO('sqlite:' . $dbName);
            $this->dbConnection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            http_response_code(500);
            $error['Database connection error'] = $e->getMessage();
            echo json_encode($error);
            exit();
        }
    }

    public function getDbConnection()
    {
        return $this->dbConnection;
    }

    //create prepared statement
    public function executeSQL($sql, $params=[]){
        $stmt = $this->dbConnection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
<?php

if (basename($_SERVER['PHP_SELF']) == 'db.php') {
    die('403 - Access Forbidden');
}

class DB {
    // To change db settings, go to /configs/config.php
    private $hostname = DB_HOST;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;

    private $dbh;
    private $error;
    private $statement;

    public function __construct() {
        // Set the Data Source Name (DSN) [https://www.php.net/manual/en/pdo.construct.php#dsn]
        $dsn = "mysql:host={$this->hostname};dbname={$this->dbname}";

        // Set options
        $options = array(
            // Make sure our connection to DB is persistent
            PDO::ATTR_PERSISTENT => true,

            // Throw exception for errors
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        // Create PDO Instance
        try {
            $this->dbh = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query) {
        // Execute prepared query
        $this->statement = $this->dbh->prepare($query);
    }

    // https://gist.github.com/geoffreyhale/57ca48bc97a7a954e9d5
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {

            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;

                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;

                default:
                    $type = PDO::PARAM_STR;
                break;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->statement->execute();
    }

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    public function resultSet() {
        $this->execute();
        
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    public function single() {
        $this->execute();

        return $this->statement->fetch(PDO::FETCH_OBJ);
    }
}
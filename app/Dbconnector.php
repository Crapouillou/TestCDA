<?php


class DbConnect
{
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = 'localhost';
        $this->dbname = 'testcda';
        $this->username = 'root';
        $this->password = '';
        $this->port = '';
    }

    public function connect()
    {
        if (isset($this->port) && !empty($this->port)) {
            $stringPort = ":" . $this->port;
        } else {
            $stringPort = "";
        }

        $dsn = "mysql:host=$this->host" . $stringPort . ";dbname=$this->dbname;charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            echo 'Erreur de connexion : ' . $e->getMessage();
            return null;
        }
    }
}

<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct()
    {
       if ($_SERVER["SERVER_NAME"] === "localhost" || $_SERVER["SERVER_ADDR"] === "127.0.0.1" || $_SERVER["SERVER_ADDR"] === "192.168.1.72")
       {
            // scan what domain is 
            $this->host = "localhost";
            $this->db_name = "activity1itelec2";
            $this->username = "root";
            $this->password = "";
        } else {
            $this->host = "localhost";
            $this->db_name = "u772084991_hotel_database";
            $this->username = "u772084991_root";
            $this->password = "itelec2Group5!";
        }
    }

    public function dbConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error" . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>

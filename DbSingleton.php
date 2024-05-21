<?php
class DbSingleton {
    private static $instance = null;
    private $conn;
    private $servername = "localhost";
    private $username = "todo"; // Remplacez par le nom d'utilisateur correct
    private $password = "openit"; // Remplacez par le mot de passe correct
    private $dbname = "todo_list";

    private function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DbSingleton();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>
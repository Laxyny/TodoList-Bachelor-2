<?php
class Database {
    private static $conn;

    public static function getConnection() {
        if (self::$conn === null) {
            $servername = "localhost";
            $username = "todo";
            $password = "openit";
            $dbname = "todo_list";

            self::$conn = new mysqli($servername, $username, $password, $dbname);

            // Vérification de la connexion
            if (self::$conn->connect_error) {
                die("Connexion échouée: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}

// Utiliser la connexion dans les DAO sans modifier les fichiers
$conn = Database::getConnection();
?>

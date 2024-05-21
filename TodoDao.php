<?php
require_once('../database.php'); // Chemin ajusté selon votre structure de fichiers
require_once('../model/Todo.php');

class TodoDao {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAll() {
        $stmt = $this->conn->prepare("SELECT * FROM todo");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];
        while ($row = $result->fetch_assoc()) {
            $todo = new Todo(
                $row['id_todo'],
                $row['titre'],
                $row['description'],
                $row['date_creation'],
                $row['date_echeance'],
                $row['id_statut'],
                $row['id_priorite'],
                $row['id_utilisateur']
            );
            $todos[] = $todo;
            error_log('Todo object created: ' . print_r($todo, true)); // Log each object
        }
        error_log('Data fetched from database: ' . print_r($todos, true)); // Log the fetched data
        return $todos;
    }
}
?>

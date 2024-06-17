<?php
require_once('../database.php'); // Ajustez le chemin selon votre structure de fichiers
require_once('../model/Todo.php');

class TodoDao {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAll() {
        $stmt = $this->conn->prepare("SELECT id_todo, titre, description, date_creation, date_echeance, id_statut, id_priorite, id_utilisateur FROM todo");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];
        while ($row = $result->fetch_assoc()) {
            error_log('Row data: ' . print_r($row, true)); // Log the row data
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

    public function fetch($id) {
        $stmt = $this->conn->prepare("SELECT id_todo, titre, description, date_creation, date_echeance, id_statut, id_priorite, id_utilisateur FROM todo WHERE id_utilisateur = ?");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
            return [];
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];
        while ($row = $result->fetch_assoc()) {
            error_log('Row data: ' . print_r($row, true)); // Log the row data
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
        error_log('Data fetched from database for user: ' . print_r($todos, true)); // Log the fetched data
        return $todos;
    }

    public function insert($todo) {
        $stmt = $this->conn->prepare("INSERT INTO todo (titre, description, date_creation, date_echeance, id_statut, id_priorite, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
            return false;
        }
        $stmt->bind_param(
            "ssssiii",
            $todo->titre,
            $todo->description,
            $todo->date_creation,
            $todo->date_echeance,
            $todo->id_statut,
            $todo->id_priorite,
            $todo->id_utilisateur
        );
        return $stmt->execute();
    }
}
?>
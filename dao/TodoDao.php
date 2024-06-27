<?php
require_once('../database.php');
require_once('../model/Todo.php');

class TodoDao {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAll() {
        $stmt = $this->conn->prepare("SELECT id_todo, titre, description, date_creation, date_echeance, id_statut, id_priorite, id_categorie, id_utilisateur FROM todo");
        if (!$stmt) {
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
                $row['id_categorie'],
                $row['id_utilisateur']
            );
            $todos[] = $todo;
        }
        return $todos;
    }

    public function fetch($id) {
        $stmt = $this->conn->prepare("SELECT id_todo, titre, description, date_creation, date_echeance, id_statut, id_priorite, id_categorie, id_utilisateur FROM todo WHERE id_utilisateur = ?");
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param("i", $id);
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
                $row['id_categorie'],
                $row['id_utilisateur']
            );
            $todos[] = $todo;
        }
        return $todos;
    }

    public function fetchAllByUser($userId) {
        $stmt = $this->conn->prepare("
            SELECT todo.*, statut.libelle as libelle_statut, priorites.libelle as libelle_priorite, categories.libelle as libelle_categorie
            FROM todo 
            JOIN statut ON todo.id_statut = statut.id_statut 
            JOIN priorites ON todo.id_priorite = priorites.id_priorite 
            JOIN categories ON todo.id_categorie = categories.id_categorie 
            WHERE id_utilisateur = ?
        ");
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];
        while ($row = $result->fetch_assoc()) {
            $todos[] = $row;
        }
        return $todos;
    }
    

    public function fetchAllWithDeleted($userId) {
        $stmt = $this->conn->prepare("SELECT id_todo, titre, description, date_creation, date_echeance, id_statut, id_priorite, id_categorie, id_utilisateur FROM todo WHERE id_utilisateur = ?");
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];
        while ($row = $result->fetch_assoc()) {
            $todos[] = new Todo(
                $row['id_todo'],
                $row['titre'],
                $row['description'],
                $row['date_creation'],
                $row['date_echeance'],
                $row['id_statut'],
                $row['id_priorite'],
                $row['id_categorie'],
                $row['id_utilisateur']
            );
        }
        return $todos;
    }

    public function fetchDeletedTodos() {
        $stmt = $this->conn->prepare("
            SELECT todo.*, utilisateurs.utilisateur as libelle_utilisateur, statut.libelle as libelle_statut, priorites.libelle as libelle_priorite, categories.libelle as libelle_categorie 
            FROM todo 
            JOIN utilisateurs ON todo.id_utilisateur = utilisateurs.id_utilisateur 
            JOIN statut ON todo.id_statut = statut.id_statut 
            JOIN priorites ON todo.id_priorite = priorites.id_priorite 
            JOIN categories ON todo.id_categorie = categories.id_categorie 
            WHERE todo.id_statut = 4
        ");
        if (!$stmt) {
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $todos = [];
        while ($row = $result->fetch_assoc()) {
            $todos[] = $row;
        }
        return $todos;
    }

    public function insert($titre, $description, $date_creation, $date_echeance, $id_statut, $id_priorite, $id_categorie, $id_utilisateur) {
        $stmt = $this->conn->prepare("INSERT INTO todo (titre, description, date_creation, date_echeance, id_statut, id_priorite, id_categorie, id_utilisateur) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("ssssiiii", $titre, $description, $date_creation, $date_echeance, $id_statut, $id_priorite, $id_categorie, $id_utilisateur);
        $result = $stmt->execute();
        if (!$result) {
            return ['success' => false, 'error' => $stmt->error];
        }
        return ['success' => true];
    }
    

    public function editStatus($id, $newTitle, $newDescription, $newDueDate, $newStatus, $newPriority, $newCategorie) {
        $stmt = $this->conn->prepare("UPDATE todo SET titre = ?, description = ?, date_echeance = ?, id_statut = ?, id_priorite = ?, id_categorie = ? WHERE id_todo = ?");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("sssiiii", $newTitle, $newDescription, $newDueDate, $newStatus, $newPriority, $newCategorie, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("UPDATE todo SET id_statut = 4 WHERE id_todo = ?");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function restore($id) {
        $stmt = $this->conn->prepare("UPDATE todo SET id_statut = 2 WHERE id_todo = ?");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
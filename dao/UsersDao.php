<?php
require_once('../database.php');
require_once('../model/Utilisateur.php');

class UtilisateurDao {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAll() {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs");
        $stmt->execute();
        $result = $stmt->get_result();
        $utilisateurs = [];
        while ($row = $result->fetch_assoc()) {
            $utilisateurs[] = new Utilisateur($row['id_utilisateur'], $row['utilisateur'], $row['mot_de_passe'], $row['role']);
        }
        return $utilisateurs;
    }

    public function fetch($id) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Utilisateur($row['id_utilisateur'], $row['utilisateur'], $row['mot_de_passe'], $row['role']);
        }
        return null;
    }

    public function login($utilisateur, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE utilisateur = ?");
        $stmt->bind_param("s", $utilisateur);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if ($user && $user['mot_de_passe'] === $password) {
            return new Utilisateur($user['id_utilisateur'], $user['utilisateur'], $user['mot_de_passe'], $user['role']);
        }
        return null;
    }
    
    public function register($utilisateur, $password, $role) {
        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (utilisateur, mot_de_passe, role) VALUES (?, ?, ?)");
        if (!$stmt) {
            return ['success' => false, 'error' => $this->conn->error];
        }
        $stmt->bind_param("sss", $utilisateur, $password, $role);
        $result = $stmt->execute();
        if (!$result) {
            return ['success' => false, 'error' => $stmt->error];
        }
        return ['success' => true];
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>

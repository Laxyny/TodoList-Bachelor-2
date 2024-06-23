<?php
require_once('../database.php'); // Ajustez le chemin selon votre structure de fichiers
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
        error_log("Login query result: " . print_r($user, true));
        if ($user && $user['mot_de_passe'] === $password) {
            return new Utilisateur($user['id_utilisateur'], $user['utilisateur'], $user['mot_de_passe'], $user['role']);
        }
        return null;
    }
    
    public function register($utilisateur, $password) {
        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (utilisateur, mot_de_passe) VALUES (?, ?)");
        $stmt->bind_param("ss", $utilisateur, $password);
        return $stmt->execute();
    }
}
?>

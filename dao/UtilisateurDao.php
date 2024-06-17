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
            $utilisateurs[] = new Utilisateur($row['id_utilisateur'], $row['email'], $row['mot_de_passe']);
        }
        return $utilisateurs;
    }

    public function fetch($id) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            return new Utilisateur($row['id_utilisateur'], $row['email'], $row['mot_de_passe']);
        }
        return null;
    }

    public function login($email, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        error_log("Login query result: " . print_r($user, true));
        if ($user && $user['mot_de_passe'] === $password) {
            return new Utilisateur($user['id_utilisateur'], $user['email'], $user['mot_de_passe']);
        }
        return null;
    }
    
    public function register($email, $password) {
        $stmt = $this->conn->prepare("INSERT INTO utilisateurs (email, mot_de_passe) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);
        return $stmt->execute();
    }
}
?>

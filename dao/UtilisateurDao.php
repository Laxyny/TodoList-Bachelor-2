<?php
require_once('../database.php'); // Ajustez le chemin selon votre structure de fichiers
require_once('../model/Utilisateur.php');

class UtilisateurDao {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function fetchAll() {
        $stmt = $this->conn->prepare("SELECT id_utilisateur, email, mot_de_passe FROM utilisateurs");
        if (!$stmt) {
            error_log('Error preparing statement: ' . $this->conn->error);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $utilisateur = [];
        while ($row = $result->fetch_assoc()) {
            error_log('Row data: ' . print_r($row, true)); // Log the row data
            $utilisateur = new Utilisateur(
                $row['id_utilisateur'],
                $row['email'],
                $row['mot_de_passe']
            );
            $utilisateurs[] = $utilisateur;
            error_log('Utilisateurs object created: ' . print_r($utilisateur, true)); // Log each object
        }
        error_log('Data fetched from database: ' . print_r($utilisateurs, true)); // Log the fetched data
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
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($user['mot_de_passe'] === $password) {
                return new Utilisateur($user['id_utilisateur'], $user['email'], $user['mot_de_passe']);
            }
        }
        return null;
    }
}
?>
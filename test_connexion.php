<?php
include 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
} else {
    echo "Connexion réussie à la base de données MySQL";
}
?>

<?php
include 'database.php';

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
} else {
    echo "Connexion réussie à la base de données MySQL";
}
?>

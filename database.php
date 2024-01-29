<?php

// Crée une connexion à la base de données et retourne l'objet de connexion
function create_database_connection()
{
    // adresse, nom utilisateur, mdp et nom de la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "todo";

    // connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifie si la connexion a réussi, sinon affiche un message d'erreur et termine le script
    if ($conn->connect_error) {
        die("Erreur de connexion " . $conn->connect_error);
    }

    // Retourne l'objet de connexion
    return $conn;
}

?>
<?php

// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "inscription";


$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de connexion à la base de données : " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];
    
    $stmt = $conn->prepare("SELECT id FROM utilisateurs WHERE nom_utilisateur = ?");
    $stmt->bind_param("s", $nom_utilisateur);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Nom d'utilisateur déjà pris. Choisissez-en un autre.";
    } else {
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, 'utilisateur')");
        $stmt->bind_param("ss", $nom_utilisateur, $mot_de_passe_hache);
        
        if ($stmt->execute()) {
            echo "Compte créé avec succès !";
        } else {
            echo "Erreur lors de la création du compte.";
        }
    }
    $stmt->close();
}

$conn->close();
?>
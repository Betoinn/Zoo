<?php
// Démarrer la session
session_start();

// Informations de connexion à la base de données
$host = "localhost";
$dbname = "parc_animalier";
$username = "root";
$password = ""; // Remplacer par le mot de passe si nécessaire

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de connexion à la base de données : " . $conn->connect_error);
}

// Vérifier que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];

    // Requête pour vérifier le nom d'utilisateur
    $stmt = $conn->prepare("SELECT id, mot_de_passe, role FROM utilisateurs WHERE nom_utilisateur = ?");
    $stmt->bind_param("s", $nom_utilisateur);
    $stmt->execute();
    $stmt->store_result();
    
    // Si l'utilisateur existe, vérifier le mot de passe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $mot_de_passe_hache, $role);
        $stmt->fetch();

        if (password_verify($mot_de_passe, $mot_de_passe_hache)) {
            // Mot de passe correct, démarrer la session
            $_SESSION["nom_utilisateur"] = $nom_utilisateur;
            $_SESSION["role"] = $role;

            echo "Connexion réussie ! Bienvenue, " . $_SESSION["nom_utilisateur"];
            header("Location: accueil.php"); // Redirection vers une page d'accueil
            exit;
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Nom d'utilisateur introuvable.";
    }
    $stmt->close();
}

$conn->close();
?>
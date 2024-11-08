<?php
// Démarrer la session une seule fois au début
session_start();

// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "inscription";

$conn = new mysqli($server, $username, $password, $databaseName);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Liste des utilisateurs (en dur, pour simplifier, bien qu'il serait préférable d'utiliser la BDD)
$utilisateurs = [
    [
        "nom_utilisateur" => "admin",
        "mot_de_passe" => password_hash("admin123", PASSWORD_DEFAULT),
        "role" => "admin"
    ],
    [
        "nom_utilisateur" => "utilisateur",
        "mot_de_passe" => password_hash("user123", PASSWORD_DEFAULT),
        "role" => "utilisateur"
    ]
];

// Vérification des informations de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_utilisateur = $_POST["nom_utilisateur"];
    $mot_de_passe = $_POST["mot_de_passe"];

    $connexion_reussie = false;
    foreach ($utilisateurs as $utilisateur) {
        // Vérifier si le nom d'utilisateur et le mot de passe sont corrects
        if ($utilisateur["nom_utilisateur"] === $nom_utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
            $connexion_reussie = true;
            
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];
            $_SESSION["role"] = $utilisateur["role"];
            
            // Redirection vers une page d'accueil protégée
            header("Location: accueil.php");
            exit; // Arrêter le script ici
        }
    }

    if (!$connexion_reussie) {
        echo "Nom d'utilisateur ou mot de passe incorrect !";
    }
}
?>
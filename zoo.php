<?php

$server = "localhost";
$username = "root";
$password = "";
$databaseName = "inscription";

//Connexion à la base de donnée
$conn = new mysqli($server, $username, $password, $databaseName);
//Check connexion
if($conn->connect_error) {
    die("connection BDD échouée");
}

$utilisateurs = [
    [
        "nom_utilisateur" => "admin",
        "mot_de_passe" => password_hash("admin123", PASSWORD_DEFAULT), // Hachage pour plus de sécurité
        "role" => "admin"
    ],
    [
        "nom_utilisateur" => "utilisateur",
        "mot_de_passe" => password_hash("user123", PASSWORD_DEFAULT),
        "role" => "utilisateur"
    ]
];

session_start();

// Liste des utilisateurs (comme définie dans l'étape 1)
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
        // Vérifier si le nom d'utilisateur existe et si le mot de passe correspond
        if ($utilisateur["nom_utilisateur"] === $nom_utilisateur && password_verify($mot_de_passe, $utilisateur["mot_de_passe"])) {
            $connexion_reussie = true;
            
            // Stocker les informations de session
            $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];
            $_SESSION["role"] = $utilisateur["role"];
            
            echo "Connexion réussie ! Bienvenue, " . $_SESSION["nom_utilisateur"];
            header("Location: accueil.php"); // Redirection vers une page d'accueil protégée
            exit;
        }
    }

    if (!$connexion_reussie) {
        echo "Nom d'utilisateur ou mot de passe incorrect !";
    }
}

session_start();

if (!isset($_SESSION["nom_utilisateur"])) {
    header("Location: connexion.php"); // Redirection vers la page de connexion si non connecté
    exit;
}


if ($_SESSION["role"] != "admin") {
    echo "Accès réservé aux administrateurs.";
    exit;
}

session_start();
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session
header("Location: connexion.php"); // Redirection vers la page de connexion
exit;


?>

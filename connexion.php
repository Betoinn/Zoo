<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = $_POST["mot_de_passe"];

    $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
    $requete->bind_param("s", $nomUtilisateur);
    $requete->execute();
    $resultat = $requete->get_result();
    $utilisateur = $resultat->fetch_assoc();

    if ($utilisateur && password_verify($motDePasse, $utilisateur["mot_de_passe"])) {
        $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];
        $_SESSION["role"] = $utilisateur["role"];
        echo "Connexion réussie !";
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
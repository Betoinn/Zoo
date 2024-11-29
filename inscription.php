<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    // Préparation de la requête d'insertion
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, 'utilisateur')");
    $requete->bind_param("ss", $nomUtilisateur, $motDePasse);

    if ($requete->execute()) {
        echo "Inscription réussie";
    } else {
        echo "Erreur lors de l'inscription. Veuillez réessayer.";
    }
}
?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les informations du formulaire
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = password_hash($_POST["mot_de_passe"], PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la base de données
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, 'utilisateur')");
    $requete->bind_param("ss", $nomUtilisateur, $motDePasse);
    $requete->execute();

    // Après l'inscription, rediriger vers la page d'accueil et afficher le formulaire de connexion
    header("Location: index.php?inscription_success=true");
    exit();
}
?>
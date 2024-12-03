<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les informations
    $nomUtilisateur = trim($_POST["nom_utilisateur"]);
    $motDePasse = trim($_POST["mot_de_passe"]);

    // Validation des champs
    if (empty($nomUtilisateur) || empty($motDePasse)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    // Hachage du mot de passe
    $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, 'utilisateur')");
    $requete->bind_param("ss", $nomUtilisateur, $motDePasseHash);

    if (!$requete->execute()) {
        echo "Erreur lors de l'inscription : " . $connexion->error;
    } else {
        echo "Inscription réussie !";
        header("Location: index.php?inscription_success=true");
        exit();
    }
}
?>
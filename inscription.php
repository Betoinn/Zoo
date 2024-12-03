<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = $_POST["mot_de_passe"];

    if (empty($nomUtilisateur) || empty($motDePasse)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    // Vérifier si le nom d'utilisateur existe déjà
    $verifRequete = $connexion->prepare("SELECT id FROM utilisateurs WHERE nom_utilisateur = ?");
    $verifRequete->bind_param("s", $nomUtilisateur);
    $verifRequete->execute();
    $verifRequete->store_result();

    if ($verifRequete->num_rows > 0) {
        echo "Ce nom d'utilisateur existe déjà.";
        exit();
    }

    // Hacher le mot de passe
    $motDePasseHache = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Insérer l'utilisateur dans la base de données
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, 'utilisateur')");
    $requete->bind_param("ss", $nomUtilisateur, $motDePasseHache);

    if ($requete->execute()) {
        // Rediriger vers la page d'accueil avec succès
        header("Location: index.php?inscription_success=true");
        exit();
    } else {
        // Afficher une erreur si la requête échoue
        echo "Erreur lors de l'inscription : " . $requete->error;
        exit();
    }
}
?>
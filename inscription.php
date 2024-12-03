<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si les champs sont bien remplis
    if (empty($_POST["nom_utilisateur"]) || empty($_POST["mot_de_passe"])) {
        echo "Erreur : Tous les champs doivent être remplis.";
        exit();
    }

    // Récupérer les informations en les sécurisant
    $nomUtilisateur = htmlspecialchars(trim($_POST["nom_utilisateur"]));
    $motDePasse = trim($_POST["mot_de_passe"]);

    // Vérifier si l'utilisateur existe déjà
    $requeteVerif = $connexion->prepare("SELECT id FROM utilisateurs WHERE nom_utilisateur = ?");
    $requeteVerif->bind_param("s", $nomUtilisateur);
    $requeteVerif->execute();
    $resultatVerif = $requeteVerif->get_result();

    if ($resultatVerif->num_rows > 0) {
        echo "Erreur : Ce nom d'utilisateur est déjà utilisé.";
        exit();
    }

    // Hachage du mot de passe
    $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Insérer dans la base de données
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, 'utilisateur')");
    $requete->bind_param("ss", $nomUtilisateur, $motDePasseHash);

    if ($requete->execute()) {
        echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: index.php?inscription_success=true");
        exit();
    } else {
        echo "Erreur lors de l'inscription : " . $connexion->error;
        exit();
    }
}
?>
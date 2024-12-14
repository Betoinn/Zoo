<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $nomUtilisateur = htmlspecialchars(trim($_POST['nom_utilisateur']));
    $motDePasse = trim($_POST['mot_de_passe']);

    // Vérification des champs vides
    if (empty($nomUtilisateur) || empty($motDePasse)) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Vérification si l'utilisateur existe déjà
    $requeteVerif = $connexion->prepare("SELECT id FROM utilisateurs WHERE nom_utilisateur = ?");
    $requeteVerif->bind_param("s", $nomUtilisateur);
    $requeteVerif->execute();
    $resultatVerif = $requeteVerif->get_result();

    if ($resultatVerif->num_rows > 0) {
        echo "<script>alert('Nom d\\'utilisateur déjà utilisé.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Définir le rôle par défaut pour l'utilisateur
    $role = ($nomUtilisateur === 'userAdmin') ? 'admin' : 'utilisateur';

    // Hachage du mot de passe
    $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, ?)");
    $requete->bind_param("sss", $nomUtilisateur, $motDePasseHash, $role);

    if ($requete->execute()) {
        echo "<script>alert('Inscription réussie ! Vous pouvez maintenant vous connecter.'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\\'inscription.'); window.location.href = 'index.html';</script>";
    }
}
?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérification que les champs ne sont pas vides
    if (empty($_POST["nom_utilisateur"]) || empty($_POST["mot_de_passe"])) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href = 'index.html';</script>";
        exit();
    }

    $nomUtilisateur = htmlspecialchars(trim($_POST["nom_utilisateur"]));
    $motDePasse = trim($_POST["mot_de_passe"]);

    // Déboguer le nom d'utilisateur
   // var_dump($nomUtilisateur); // Affiche la valeur de nom_utilisateur

    // Vérification si l'utilisateur existe déjà
    $requeteVerif = $connexion->prepare("SELECT id FROM utilisateurs WHERE nom_utilisateur = ?");
    if ($requeteVerif === false) {
        die('Erreur dans la préparation de la requête : ' . $connexion->error);
    }
    $requeteVerif->bind_param("s", $nomUtilisateur);
    if (!$requeteVerif->execute()) {
        die('Erreur dans l\'exécution de la requête : ' . $requeteVerif->error);
    }
    $resultatVerif = $requeteVerif->get_result();

    if ($resultatVerif->num_rows > 0) {
        echo "<script>alert('Nom d\'utilisateur déjà utilisé.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Hachage du mot de passe
    $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Insertion dans la base de données
    $requete = $connexion->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, role) VALUES (?, ?, ?)");
    $requete->bind_param("sss", $nomUtilisateur, $motDePasseHash, $role);

    if ($requete->execute()) {
        echo "<script>alert('Inscription réussie ! Vous pouvez maintenant vous connecter.'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'inscription.'); window.location.href = 'index.html';</script>";
    }
}
?>
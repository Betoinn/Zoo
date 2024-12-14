<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $nomUtilisateur = htmlspecialchars(trim($_POST['nom_utilisateur']));
    $motDePasse = trim($_POST['mot_de_passe']);

    // Vérification des champs vides
    if (empty($nomUtilisateur) || empty($motDePasse)) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Récupération de l'utilisateur dans la base de données
    $requete = $connexion->prepare("SELECT nom_utilisateur, mot_de_passe, role FROM utilisateurs WHERE nom_utilisateur = ?");
    $requete->bind_param("s", $nomUtilisateur);
    $requete->execute();
    $resultat = $requete->get_result();

    if ($resultat->num_rows > 0) {
        $utilisateur = $resultat->fetch_assoc();

        // Vérification du mot de passe
        if (password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            // Connexion réussie
            session_start();
            $_SESSION['nom_utilisateur'] = $nomUtilisateur;
            $_SESSION['role'] = $utilisateur['role'];

            if ($utilisateur['role'] === 'admin') {
                echo "<script>alert('Bienvenue administrateur !'); window.location.href = 'admin_dashboard.php';</script>";
            } else {
                echo "<script>alert('Connexion réussie !'); window.location.href = 'user_dashboard.php';</script>";
            }
        } else {
            // Mot de passe incorrect
            echo "<script>alert('Mot de passe incorrect.'); window.location.href = 'index.html';</script>";
        }
    } else {
        // Utilisateur non trouvé
        echo "<script>alert('Nom d\\'utilisateur non trouvé.'); window.location.href = 'index.html';</script>";
    }
}
?>
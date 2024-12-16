<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["nom_utilisateur"]) || empty($_POST["mot_de_passe"])) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Vérification pour l'admin
    $nomUtilisateur = htmlspecialchars(trim($_POST["nom_utilisateur"]));
    $motDePasse = trim($_POST["mot_de_passe"]);

    if ($nomUtilisateur === "userAdmin" && $motDePasse === "mdpAdmin") {
        // Stocker les informations dans des cookies
        setcookie("nom_utilisateur", "userAdmin", time() + 3600, "/"); // 1 heure
        setcookie("role", "admin", time() + 3600, "/"); // 1 heure
        echo "<script>alert('Connexion réussie en tant qu\'administrateur.'); window.location.href = 'index.html';</script>";
        exit();
    }

    // Requête pour vérifier les informations de connexion
    $requete = $connexion->prepare("SELECT id, mot_de_passe, role FROM utilisateurs WHERE nom_utilisateur = ?");
    $requete->bind_param("s", $nomUtilisateur);
    $requete->execute();
    $resultat = $requete->get_result();

    if ($resultat->num_rows === 1) {
        $utilisateur = $resultat->fetch_assoc();

        // Vérifier le mot de passe
        if (password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            // Connexion réussie : Stocker les informations dans des cookies
            setcookie("nom_utilisateur", $nomUtilisateur, time() + 3600, "/"); // Cookie valable 1h
            setcookie("role", $utilisateur['role'], time() + 3600, "/"); 

            // Rediriger vers la page d'accueil
            header("Location: index.html");
            exit();
        } else {
            echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect.'); window.location.href = 'index.html';</script>";
        }
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect.'); window.location.href = 'index.html';</script>";
    }

   
}


?>
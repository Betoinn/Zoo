<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nomUtilisateur = $_POST["nom_utilisateur"];
    $motDePasse = $_POST["mot_de_passe"];

    // Vérification pour l'admin spécifique
    if ($nomUtilisateur === "userAdmin" && $motDePasse === "mdpAdmin") {
        // Stocker les informations dans des cookies
        setcookie("nom_utilisateur", "userAdmin", time() + 3600, "/"); // Cookie valable 1h
        setcookie("role", "admin", time() + 3600, "/"); // Cookie valable 1h
        echo "Connexion réussie en tant qu'administrateur.";
        exit;
    }

    
    // Vérification dans la base de données
    $requete = $connexion->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
        $requete->bind_param("s", $nomUtilisateur);
        $requete->execute();
        $resultat = $requete->get_result();
        $utilisateur = $resultat->fetch_assoc();
    
        if ($utilisateur && password_verify($motDePasse, $utilisateur["mot_de_passe"])) {
            // Connexion réussie : Stocker les informations de l'utilisateur dans des cookies
            setcookie("nom_utilisateur", $utilisateur["nom_utilisateur"], time() + 3600, "/"); // Cookie valable 1h
            setcookie("role", $utilisateur["role"], time() + 3600, "/"); // Cookie valable 1h
    
            echo "Connexion réussie !"
            exit();
        } else {
            // Si l'authentification échoue
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
    ?>
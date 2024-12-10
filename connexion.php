 
<?php
include 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["nom_utilisateur"]) || empty($_POST["mot_de_passe"])) {
        echo "<script>alert('Veuillez remplir tous les champs.'); window.location.href = 'index.html';</script>";
        exit();
    }

 // Vérification pour l'admin spécifique
 if ($nomUtilisateur === "userAdmin" && $motDePasse === "mdpAdmin") {
    // Stocker les informations dans des cookies
    setcookie("nom_utilisateur", "userAdmin", time() + 3600, "/"); // Cookie valable 1h
    setcookie("role", "admin", time() + 3600, "/"); // Cookie valable 1h
    echo "Connexion réussie en tant qu'administrateur.";
    exit;
}


$nomUtilisateur = htmlspecialchars(trim($_POST["nom_utilisateur"]));
$motDePasse = trim($_POST["mot_de_passe"]);

// Rechercher l'utilisateur dans la base de données
$requete = $connexion->prepare("SELECT id, mot_de_passe, role FROM utilisateurs WHERE nom_utilisateur = ?");
$requete->bind_param("s", $nomUtilisateur);
$requete->execute();
$resultat = $requete->get_result();

if ($resultat->num_rows === 1) {
    $utilisateur = $resultat->fetch_assoc();

    // Vérifier le mot de passe
    if (password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
        // Connexion réussie
        $_SESSION['id'] = $utilisateur['id'];
        $_SESSION['nom_utilisateur'] = $nomUtilisateur;
        $_SESSION['role'] = $utilisateur['role'];

        // Rediriger en fonction du rôle
        if ($_SESSION['role'] === 'administrateur') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.html");
        }
        exit();
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect.'); window.location.href = 'index.html';</script>";
    }
} else {
    echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect.'); window.location.href = 'index.html';</script>";
}
}
?>
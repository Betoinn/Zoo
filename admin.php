<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_COOKIE["role"]) && $_COOKIE["role"] === "admin") {
    $enclosId = $_POST["enclos_id"];
    $nouveauStatut = $_POST["statut"]; // "ouvert" ou "en travaux"

    $requete = $connexion->prepare("UPDATE enclos SET statut = ? WHERE id = ?");
    $requete->bind_param("si", $nouveauStatut, $enclosId);
    $requete->execute();

    echo "Statut de l'enclos mis à jour.";
} else {
    echo "Accès refusé.";
}
?>
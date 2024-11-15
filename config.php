<?php
// config.php
$serveur = "localhost";
$nomUtilisateur = "root";
$motDePasse = "";
$nomBaseDeDonnees = "inscription";

$connexion = new mysqli($serveur, $nomUtilisateur, $motDePasse, $nomBaseDeDonnees);

if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}
?>
<?php
$host = "localhost";  // Adresse du serveur MySQL
$user = "root";       // Nom d'utilisateur MySQL
$pass = "";           // Mot de passe MySQL (laisser vide si WAMP par défaut)
$dbname = "inscription"; // Nom de ta base de données

$connexion = new mysqli($host, $user, $pass, $dbname);

// Vérification de la connexion
if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}
?>
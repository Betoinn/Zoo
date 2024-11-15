<?php
// enclos.php
include 'config.php';

$requeteEnclos = $connexion->query("SELECT * FROM enclos");
$enclos = $requeteEnclos->fetch_all(MYSQLI_ASSOC);

$requeteAnimaux = $connexion->query("SELECT * FROM animaux");
$animaux = $requeteAnimaux->fetch_all(MYSQLI_ASSOC);

foreach ($enclos as $enclosItem) {
    echo "Enclos : " . $enclosItem["nom_enclos"] . "<br>";
    foreach ($animaux as $animal) {
        if ($animal["enclos_id"] === $enclosItem["id"]) {
            echo " - Animal : " . $animal["nom_animal"] . "<br>";
        }
    }
}
?>
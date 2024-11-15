<?php
// enclos.php
include 'config.php'; // inclut la connexion à la base de données

// Récupérer tous les enclos
$requeteEnclos = $connexion->query("SELECT * FROM enclos");
$enclos = $requeteEnclos->fetch_all(MYSQLI_ASSOC);

foreach ($enclos as $enclosItem) {
    echo "Enclos : " . $enclosItem["nom_enclos"] . "<br>";

    // Récupérer les animaux dans cet enclos spécifique
    $enclosId = $enclosItem["id"];
    $requeteAnimaux = $connexion->prepare("SELECT nom_animal FROM animaux WHERE enclos_id = ?");
    $requeteAnimaux->bind_param("i", $enclosId);
    $requeteAnimaux->execute();
    $resultatAnimaux = $requeteAnimaux->get_result();

    // Afficher les animaux associés à cet enclos
    while ($animal = $resultatAnimaux->fetch_assoc()) {
        echo " - Animal : " . $animal["nom_animal"] . "<br>";
    }
    echo "<br>";
}
?>
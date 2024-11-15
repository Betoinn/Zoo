<?php
// animaux.php
include 'config.php'; // inclut la connexion à la base de données

// Récupérer tous les animaux et leurs enclos associés
$requeteAnimaux = $connexion->query("
    SELECT animaux.nom_animal, enclos.nom_enclos 
    FROM animaux 
    LEFT JOIN enclos ON animaux.enclos_id = enclos.id
");

$animaux = $requeteAnimaux->fetch_all(MYSQLI_ASSOC);

// Afficher chaque animal avec son enclos
foreach ($animaux as $animal) {
    echo "Animal : " . $animal["nom_animal"] . "<br>";
    
    // Afficher l'enclos de l'animal, ou un message s'il n'en a pas
    if ($animal["nom_enclos"]) {
        echo " - Enclos : " . $animal["nom_enclos"] . "<br>";
    } else {
        echo " - Enclos : Non attribué<br>";
    }
    echo "<br>";
}
?>
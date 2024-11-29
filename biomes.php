<?php
include 'config.php';

// Récupérer tous les biomes
$requete = $connexion->prepare("SELECT id, nom_biome FROM biomes");
$requete->execute();
$resultat = $requete->get_result();

$biomes = [];
while ($biome = $resultat->fetch_assoc()) {
    $biomes[] = $biome;
}

// Retourner les données au format JSON
header('Content-Type: application/json');
echo json_encode($biomes);
?>
<?php
include 'config.php';

// Requête pour récupérer les biomes et leurs enclos
$queryBiomes = "
    SELECT biomes.id AS biome_id, biomes.nom_biome, enclos.id AS enclos_id, enclos.nom_enclos 
    FROM biomes 
    LEFT JOIN enclos ON biomes.id = enclos.id_biome 
    ORDER BY biomes.id, enclos.id
";

$result = $connexion->query($queryBiomes);

$biomes = [];
while ($row = $result->fetch_assoc()) {
    $biomeId = $row['biome_id'];
    if (!isset($biomes[$biomeId])) {
        $biomes[$biomeId] = [
            'nom_biome' => $row['nom_biome'],
            'enclos' => []
        ];
    }
    if ($row['enclos_id']) {
        $biomes[$biomeId]['enclos'][] = [
            'id' => $row['enclos_id'],
            'nom_enclos' => $row['nom_enclos']
        ];
    }
}

// Retourner les données au format JSON
header('Content-Type: application/json');
echo json_encode($biomes);

?>
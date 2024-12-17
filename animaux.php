<?php
header('Content-Type: application/json');
include('config.php');

// Récupération des biomes, enclos et animaux
$query = "
    SELECT b.id AS biome_id, b.nom_biome, b.couleur_code,
           e.id AS enclos_id, e.nom_enclos, e.statut,
           a.id AS animal_id, a.nom_animal
    FROM biomes AS b
    LEFT JOIN enclos AS e ON b.id = e.biome_id
    LEFT JOIN animaux AS a ON e.id = a.enclos_id
    ORDER BY b.id, e.id, a.id
";

$result = mysqli_query($conn, $query);

$biomes = [];
while ($row = mysqli_fetch_assoc($result)) {
    $biomeId = $row['biome_id'];
    $enclosId = $row['enclos_id'];

    // Organisation des données
    if (!isset($biomes[$biomeId])) {
        $biomes[$biomeId] = [
            'nom' => $row['nom_biome'],
            'couleur' => $row['couleur_code'],
            'enclos' => []
        ];
    }

    if ($enclosId) {
        if (!isset($biomes[$biomeId]['enclos'][$enclosId])) {
            $biomes[$biomeId]['enclos'][$enclosId] = [
                'nom' => $row['nom_enclos'],
                'statut' => $row['statut'],
                'animaux' => []
            ];
        }

        if ($row['animal_id']) {
            $biomes[$biomeId]['enclos'][$enclosId]['animaux'][] = $row['nom_animal'];
        }
    }
}

echo json_encode(array_values($biomes));
?>
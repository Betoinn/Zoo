<?php
include 'config.php';  // Fichier de connexion

$query = "
    SELECT b.nom_biome, e.id AS enclos_id, e.nom_enclos, e.image_enclos, e.statut, 
           a.id AS animal_id, a.nom_animal, a.image_animal
    FROM enclos AS e
    LEFT JOIN animaux AS a ON e.id = a.enclos_id
    LEFT JOIN biomes AS b ON e.biome_id = b.id
    ORDER BY b.nom_biome, e.id, a.id
";

$result = mysqli_query($connexion, $query);
if (!$result) {
    die("Erreur SQL : " . mysqli_error($connexion));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $biome = $row['nom_biome'];
    $enclosId = $row['enclos_id'];

    if (!isset($data[$biome])) {
        $data[$biome] = [];
    }

    if (!isset($data[$biome][$enclosId])) {
        $data[$biome][$enclosId] = [
            'nom_enclos' => $row['nom_enclos'],
            'image_enclos' => ''.$row['image_enclos'].'',
            'statut' => $row['statut'],  // Ajouter le statut de l'enclos
            'animaux' => []
        ];
    }

    if ($row['animal_id']) {
        $data[$biome][$enclosId]['animaux'][] = [
            'nom_animal' => $row['nom_animal'],
            'image_animal' => ''.$row['image_animal'].'',
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
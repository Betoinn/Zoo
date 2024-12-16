<?php
include 'config.php';

// Requête pour récupérer les biomes et les enclos associés
$query = "SELECT biomes.id AS biome_id, biomes.nom_biome, enclos.id AS enclos_id, enclos.nom_enclos
          FROM biomes
          LEFT JOIN enclos ON biomes.id = enclos.id_biome
          ORDER BY biomes.id, enclos.id";
$result = $connexion->query($query);

// Organiser les données
$biomes = [];
while ($row = $result->fetch_assoc()) {
    $biomes[$row['biome_id']]['nom_biome'] = $row['nom_biome'];
    $biomes[$row['biome_id']]['enclos'][] = [
        'id' => $row['enclos_id'],
        'nom_enclos' => $row['nom_enclos']
    ];
}

// Générer la page HTML avec les biomes et les enclos
foreach ($biomes as $biome) {
    echo "<h2>" . $biome['nom_biome'] . "</h2>";
    foreach ($biome['enclos'] as $enclos) {
        echo "<a href='enclos.php?id_enclos=" . $enclos['id'] . "'>Enclos " . $enclos['nom_enclos'] . "</a><br>";
    }
}
?>
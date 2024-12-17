<?php
// Inclure la configuration de la base de données
include('config.php');

// Récupération des biomes
$queryBiomes = "SELECT * FROM biomes";
$resultBiomes = mysqli_query($conn, $queryBiomes);

// Préparation des données
$biomes = [];
while ($row = mysqli_fetch_assoc($resultBiomes)) {
    $biomes[$row['id']] = [
        'nom' => $row['nom_biome'],
        'couleur' => $row['couleur_code'],
        'enclos' => []
    ];
}

// Récupération des enclos et des animaux associés
$queryEnclos = "SELECT enclos.id AS enclos_id, enclos.nom_enclos, enclos.statut, enclos.biome_id,
                animaux.id AS animal_id, animaux.nom_animal
                FROM enclos
                LEFT JOIN animaux ON enclos.id = animaux.enclos_id";
$resultEnclos = mysqli_query($conn, $queryEnclos);

while ($row = mysqli_fetch_assoc($resultEnclos)) {
    $biomeId = $row['biome_id'];
    $enclosId = $row['enclos_id'];
    
    // Organisation des enclos dans chaque biome
    if (!isset($biomes[$biomeId]['enclos'][$enclosId])) {
        $biomes[$biomeId]['enclos'][$enclosId] = [
            'nom' => $row['nom_enclos'],
            'statut' => $row['statut'],
            'animaux' => []
        ];
    }
    
    // Ajouter les animaux à chaque enclos
    if (!empty($row['animal_id'])) {
        $biomes[$biomeId]['enclos'][$enclosId]['animaux'][] = $row['nom_animal'];
    }
}

// Passer les données à JavaScript via JSON
$data = json_encode($biomes);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Animaux</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="content">
        <h1>Découvrez Nos Animaux</h1>
        <!-- Contenu des biomes et enclos -->
        <div id="biomes-container"></div>
    </div>

    <!-- Pop-up pour les enclos -->
    <div id="popup" class="hidden">
        <div id="popup-content">
            <span id="close-popup">&times;</span>
            <h2 id="popup-title"></h2>
            <div id="carousel-container">
                <!-- Carrousel d'images ici -->
            </div>
            <p id="popup-status"></p>
        </div>
    </div>

    <script>
        const biomesData = <?php echo $data; ?>;
    </script>
    <script src="animaux.js"></script>
</body>
</html>
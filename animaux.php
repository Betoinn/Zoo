<?php
include 'config.php';  // Inclure le fichier de connexion à la base de données

// Requête SQL pour récupérer les animaux et les enclos avec leurs images
$query = "
    SELECT e.id AS enclos_id, e.nom_enclos, e.image_enclos, 
           a.id AS animal_id, a.nom_animal, a.image_animal
    FROM enclos AS e
    LEFT JOIN animaux AS a ON e.id = a.enclos_id
    ORDER BY e.id, a.id
";

$result = mysqli_query($connexion, $query);

// Vérification de la requête
if (!$result) {
    die("Erreur SQL : " . mysqli_error($connexion));
}

// Tableau pour stocker les données des enclos et des animaux
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $enclosId = $row['enclos_id'];
    $animalId = $row['animal_id'];

    // Ajouter l'enclos si non déjà existant dans le tableau
    if (!isset($data[$enclosId])) {
        $data[$enclosId] = [
            'nom_enclos' => $row['nom_enclos'],
            'image_enclos' => $row['image_enclos'],
            'animaux' => []
        ];
    }

    // Ajouter l'animal à l'enclos respectif
    if ($animalId) {
        $data[$enclosId]['animaux'][] = [
            'animal_id' => $animalId,
            'nom_animal' => $row['nom_animal'],
            'image_animal' => $row['image_animal']
        ];
    }
}

// Envoi des données en JSON
header('Content-Type: application/json');
echo json_encode(array_values($data), JSON_PRETTY_PRINT);
?>
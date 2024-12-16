<?php
include 'config.php';

// Vérifier si un ID d'animal est fourni
if (!isset($_GET['id_animal'])) {
    die(json_encode(['error' => 'ID de l\'animal non fourni']));
}

$idAnimal = intval($_GET['id_animal']);

// Requête pour récupérer les informations de l'animal
$queryAnimal = $connexion->prepare("
    SELECT nom_animal, id_enclos 
    FROM animaux 
    WHERE id = ?
");
$queryAnimal->bind_param("i", $idAnimal);
$queryAnimal->execute();
$result = $queryAnimal->get_result();

if ($result->num_rows === 0) {
    die(json_encode(['error' => 'Animal introuvable']));
}

$animal = $result->fetch_assoc();

// Retourner les données au format JSON
header('Content-Type: application/json');
echo json_encode($animal);
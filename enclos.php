<?php
include 'config.php';

// Vérifier si un ID d'enclos est fourni
if (!isset($_GET['id_enclos'])) {
    die(json_encode(['error' => 'ID de l\'enclos non fourni']));
}

$idEnclos = intval($_GET['id_enclos']);

// Requête pour récupérer les animaux de l'enclos
$queryAnimaux = $connexion->prepare("
    SELECT id, nom_animal 
    FROM animaux 
    WHERE id_enclos = ?
");
$queryAnimaux->bind_param("i", $idEnclos);
$queryAnimaux->execute();
$result = $queryAnimaux->get_result();

$animaux = [];
while ($row = $result->fetch_assoc()) {
    $animaux[] = $row;
}

// Retourner les données au format JSON
header('Content-Type: application/json');
echo json_encode($animaux);

?>
<?php
include 'config.php';

// Vérification de l'ID de l'animal
if (!isset($_GET['id_animal'])) {
    die("Animal non spécifié");
}

$idAnimal = intval($_GET['id_animal']);

// Requête pour récupérer les détails de l'animal
$query = $connexion->prepare("SELECT nom_animal, description, id_enclos FROM animaux WHERE id = ?");
$query->bind_param("i", $idAnimal);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("Animal non trouvé");
}

$row = $result->fetch_assoc();
$nomAnimal = $row['nom_animal'];
$description = $row['description'];
$idEnclos = $row['id_enclos'];

// Afficher les informations sur l'animal
echo "<h2>Détails de l'animal: $nomAnimal</h2>";
echo "<p>Description: $description</p>";
echo "<p>Enclos: <a href='enclos.php?id_enclos=$idEnclos'>Enclos $idEnclos</a></p>";
?>
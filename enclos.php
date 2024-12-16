<?php
include 'config.php';

// Vérification de l'ID de l'enclos
if (!isset($_GET['id_enclos'])) {
    die("Enclos non spécifié");
}

$idEnclos = intval($_GET['id_enclos']);

// Requête pour récupérer les animaux de cet enclos
$query = $connexion->prepare("SELECT id, nom_animal FROM animaux WHERE id_enclos = ?");
$query->bind_param("i", $idEnclos);
$query->execute();
$result = $query->get_result();

// Afficher les animaux
echo "<h2>Animaux de l'enclos $idEnclos :</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<a href='animal.php?id_animal=" . $row['id'] . "'>Animal: " . $row['nom_animal'] . "</a><br>";
}
?>
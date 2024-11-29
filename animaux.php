<?php
include 'config.php';

// Vérifier si un ID d'enclos est passé
if (isset($_GET['enclos_id'])) {
    $enclosId = intval($_GET['enclos_id']);

    // Récupérer les animaux liés à cet enclos
    $requete = $connexion->prepare("SELECT nom_animal, espece FROM animaux WHERE enclos_id = ?");
    $requete->bind_param("i", $enclosId);
    $requete->execute();
    $resultat = $requete->get_result();

    $animaux = [];
    while ($animal = $resultat->fetch_assoc()) {
        $animaux[] = $animal;
    }

    // Retourner les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($animaux);
} else {
    echo json_encode(["erreur" => "Aucun ID d'enclos spécifié."]);
}
?>
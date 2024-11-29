<?php
include 'config.php';

// Vérifier si un ID de biome est passé
if (isset($_GET['biome_id'])) {
    $biomeId = intval($_GET['biome_id']);

    // Récupérer les enclos liés au biome
    $requete = $connexion->prepare("SELECT id, nom_enclos FROM enclos WHERE biome_id = ?");
    $requete->bind_param("i", $biomeId);
    $requete->execute();
    $resultat = $requete->get_result();

    $enclos = [];
    while ($enclosRow = $resultat->fetch_assoc()) {
        $enclos[] = $enclosRow;
    }

    // Retourner les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($enclos);
} else {
    echo json_encode(["erreur" => "Aucun ID de biome spécifié."]);
}
?>
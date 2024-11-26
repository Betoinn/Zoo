<?php
include 'config.php'; 

// Ajouter un horaire pour un enclos
function ajouterOuModifierHoraire($enclos_id, $horaire) {
    global $connexion;
    // Vérifier si un horaire existe déjà pour cet enclos
    $sql = "SELECT id FROM horaires_repas WHERE enclos_id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $enclos_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $sql = "UPDATE horaires_repas SET horaire = ? WHERE enclos_id = ?";
    } else {
        $sql = "INSERT INTO horaires_repas (horaire, enclos_id) VALUES (?, ?)";
    }
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("si", $horaire, $enclos_id);
    if ($stmt->execute()) {
        return "Horaire mis à jour ou ajouté avec succès.";
    } else {
        return "Erreur lors de l'ajout/mise à jour de l'horaire : " . $stmt->error;
    }
}

// Afficher les horaires
function listerHoraires() {
    global $connexion;
    $sql = "SELECT enclos_id, horaire FROM horaires_repas";
    $result = $connexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
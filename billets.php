<?php
include 'config.php'; 


function ajouterBillet($utilisateur_id, $date_achat) {
    global $connexion;
    $sql = "INSERT INTO billets (utilisateur_id, date_achat, valide) VALUES (?, ?, 0)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("is", $utilisateur_id, $date_achat);
    if ($stmt->execute()) {
        return "Billet ajouté avec succès.";
    } else {
        return "Erreur lors de l'ajout du billet : " . $stmt->error;
    }
}

// Lister tous les billets 
function listerBillets() {
    global $connexion;
    $sql = "SELECT * FROM billets";
    $result = $connexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Valider un billet 
function validerBillet($id) {
    global $connexion;
    $sql = "UPDATE billets SET valide = 1 WHERE id = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return "Billet validé avec succès.";
    } else {
        return "Erreur lors de la validation du billet : " . $stmt->error;
    }
}
?>
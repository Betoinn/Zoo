<?php
include 'config.php'; // Connexion à la base de données

// Ajouter un point d'intérêt
function ajouterPointInteret($nom_point, $type) {
    global $connexion;
    $sql = "INSERT INTO points_interet (nom_point, type) VALUES (?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ss", $nom_point, $type);
    if ($stmt->execute()) {
        return "Point d'intérêt ajouté avec succès.";
    } else {
        return "Erreur lors de l'ajout du point d'intérêt : " . $stmt->error;
    }
}

// Lister tous les points d'intérêt
function listerPointsInteret() {
    global $connexion;
    $sql = "SELECT * FROM points_interet";
    $result = $connexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Lister les points d'intérêt par type (enclos, restaurant, gare)
function listerPointsParType($type) {
    global $connexion;
    $sql = "SELECT * FROM points_interet WHERE type = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enclosId = $_POST["enclos_id"];
    $utilisateurId = $_POST["utilisateur_id"];
    $note = $_POST["note"];
    $commentaire = $_POST["commentaire"];

    $requete = $connexion->prepare("INSERT INTO avis (enclos_id, utilisateur_id, note, commentaire) VALUES (?, ?, ?, ?)");
    $requete->bind_param("iiis", $enclosId, $utilisateurId, $note, $commentaire);
    $requete->execute();

    echo "Avis ajouté avec succès !";
}
?>
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["nom_animal"])) {
    $nomAnimal = $_GET["nom_animal"];

    $requete = $connexion->prepare("SELECT e.nom_enclos FROM animaux a JOIN enclos e ON a.enclos_id = e.id WHERE a.nom_animal = ?");
    $requete->bind_param("s", $nomAnimal);
    $requete->execute();
    $resultat = $requete->get_result();

    while ($row = $resultat->fetch_assoc()) {
        echo "Enclos : " . $row["nom_enclos"] . "<br>";
    }
}
?>
<?php
include 'config.php';

// Vérification du rôle de l'utilisateur (admin)
if (!isset($_COOKIE['role']) || $_COOKIE['role'] !== 'admin') {
    echo "Accès interdit : vous devez être un administrateur.";
    exit;
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $enclos_id = $_POST["enclos_id"];
    $etat = $_POST["etat"];

    // Requête pour mettre à jour l'état de l'enclos
    $requete = $connexion->prepare("UPDATE enclos SET etat = ? WHERE id = ?");
    $requete->bind_param("si", $etat, $enclos_id);
    
    if ($requete->execute()) {
        echo "L'état de l'enclos a été modifié avec succès.";
    } else {
        echo "Erreur lors de la modification de l'état de l'enclos.";
    }
}

/* 
Partie html :

<form action="modifier_enclos.php" method="POST">
    <label for="enclos_id">Sélectionnez l'enclos :</label>
    <select name="enclos_id" id="enclos_id">
        <!-- Exemple : récupération des enclos depuis la base de données -->
        <?php
        $result = $connexion->query("SELECT id, nom_enclos FROM enclos");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nom_enclos']}</option>";
        }
        ?>
    </select>
    
    <label for="etat">Sélectionnez l'état :</label>
    <select name="etat" id="etat">
        <option value="ouvert">Ouvert</option>
        <option value="en travaux">En travaux</option>
    </select>

    <button type="submit">Modifier l'état de l'enclos</button>
</form>
*/
?>


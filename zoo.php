<?php

$server = "localhost";
$username = "root";
$password = "";
$databaseName = "inscription";

//Connexion à la base de donnée
$conn = new mysqli($server, $username, $password, $databaseName);
//Check connexion
if($conn->connect_error) {
    die("connection BDD échouée");
}


?>

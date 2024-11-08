<?php
// Démarrer la session
session_start();

// Tableau des utilisateurs (en mémoire)
$utilisateurs = [
    [
        "nom_utilisateur" => "admin",
        "mot_de_passe" => password_hash("admin2512", PASSWORD_DEFAULT), // Hachage du mot de passe
        "role" => "admin"
    ],
    [
        "nom_utilisateur" => "utilisateur",
        "mot_de_passe" => password_hash("user2512", PASSWORD_DEFAULT),
        "role" => "utilisateur"
    ]
];

// Vérifier que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées en POST
    $data = json_decode(file_get_contents("php://input"), true);

    // Vérifier que les données nécessaires sont présentes
    if (isset($data["nom_utilisateur"]) && isset($data["mot_de_passe"])) {
        // Parcourir le tableau des utilisateurs pour vérifier la correspondance
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur["nom_utilisateur"] == $data["nom_utilisateur"] &&
                password_verify($data["mot_de_passe"], $utilisateur["mot_de_passe"])) {
                
                // Stocker les informations dans la session
                $_SESSION["nom_utilisateur"] = $utilisateur["nom_utilisateur"];
                $_SESSION["role"] = $utilisateur["role"];

                // Réponse de connexion réussie
                http_response_code(200); // Succès
                echo json_encode(["message" => "Connexion réussie", "nom_utilisateur" => $_SESSION["nom_utilisateur"], "role" => $_SESSION["role"]]);
                exit;
            }
        }

        // Si aucun utilisateur n'a été trouvé avec les identifiants fournis
        http_response_code(401); // Non autorisé
        echo json_encode(["message" => "Nom d'utilisateur ou mot de passe incorrect."]);
    } else {
        http_response_code(400); // Mauvaise requête (données manquantes)
        echo json_encode(["message" => "Données manquantes."]);
    }
}
?>
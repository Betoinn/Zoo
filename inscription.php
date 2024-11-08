<?php
tst
// Connexion à la base de données
$server = "localhost";
$username = "root";
$password = "";
$databaseName = "inscription";

$conn = new mysqli($server, $username, $password, $databaseName);
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

$utilisateurs = [
    [
        "nom_utilisateur" => "admin",
        "mot_de_passe" => password_hash("admin123", PASSWORD_DEFAULT), // Hachage du mot de passe
        "role" => "admin"
    ],
    [
        "nom_utilisateur" => "utilisateur",
        "mot_de_passe" => password_hash("user123", PASSWORD_DEFAULT),
        "role" => "utilisateur"
    ]
];

// Vérifier que la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées en POST
    $data = json_decode(file_get_contents("php://input"), true);

    // Vérifier que les données obligatoires sont présentes
    if (isset($data["nom_utilisateur"]) && isset($data["mot_de_passe"])) {
        // Vérifier si le nom d'utilisateur existe déjà
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur["nom_utilisateur"] == $data["nom_utilisateur"]) {
                http_response_code(409); // Conflit (nom d'utilisateur déjà pris)
                echo json_encode(["message" => "Nom d'utilisateur déjà pris."]);
                exit;
            }
        }

        // Ajouter le nouvel utilisateur avec le mot de passe haché
        $nouvel_utilisateur = [
            "nom_utilisateur" => $data["nom_utilisateur"],
            "mot_de_passe" => password_hash($data["mot_de_passe"], PASSWORD_DEFAULT),
            "role" => "utilisateur" // Par défaut, rôle utilisateur
        ];

        // Ajouter l'utilisateur au tableau
        $utilisateurs[] = $nouvel_utilisateur;

        // Simuler l'enregistrement en mémoire
        http_response_code(201); // Créé
        echo json_encode(["message" => "Compte créé avec succès."]);
    } else {
        http_response_code(400); // Mauvaise requête (données manquantes)
        echo json_encode(["message" => "Données manquantes."]);
    }
}
?>
<?php
// Récupère les données envoyées en tant que JSON
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // Chemin du fichier JSON où les données seront enregistrées
    $file = 'form_data.json';

    // Vérifie si le fichier existe, s'il n'existe pas, le crée
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
    }

    // Lit les données JSON existantes depuis le fichier
    $current_data = json_decode(file_get_contents($file), true);

    // Ajoute les nouvelles données à celles existantes
    $current_data[] = $data;

    // Écrit les données combinées dans le fichier JSON
    if (file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT))) {
        // Réponse HTTP 200 - OK
        http_response_code(200);
        echo json_encode(array("message" => "Les données ont été enregistrées avec succès."));
    } else {
        // Réponse HTTP 500 - Erreur interne du serveur
        http_response_code(500);
        echo json_encode(array("message" => "Une erreur est survenue lors de l'enregistrement des données."));
    }
} else {
    // Réponse HTTP 400 - Mauvaise requête
    http_response_code(400);
    echo json_encode(array("message" => "Données non valides."));
}
?>

<?php
// api-proxy.php - Fichier PHP pour agir comme un proxy vers l'API externe

// Récupérez la clé d'API depuis une variable d'environnement sécurisée
$apiKey = 'feur';

// URL de l'API externe
$apiUrl = "https://eligoal.com/e-veille/api/post";

// Configuration de l'en-tête de la requête
$options = [
    'http' => [
        'header' => "X-API-Key: $apiKey\r\n",
    ],
];

$context = stream_context_create($options);

try {
    // Effectuez une requête GET à l'API externe avec l'en-tête de la clé d'API
    $apiResponse = file_get_contents($apiUrl, false, $context);

    // Vérifiez si la réponse est valide
    if ($apiResponse !== false) {
        // Renvoyez la réponse JSON à l'application front-end
        header('Content-Type: application/json');
        echo $apiResponse;
    } else {
        // Gérez les erreurs
        http_response_code(500); // Erreur de serveur interne
        echo json_encode(['error' => 'Erreur lors de la récupération des données depuis l\'API.']);
    }
} catch (Exception $e) {
    // Gérez les exceptions
    http_response_code(500); // Erreur de serveur interne
    echo json_encode(['error' => 'Erreur : ' . $e->getMessage()]);
}

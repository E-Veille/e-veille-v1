<?php
$apiKey = 'feur';

// Récupérer la demande du front-end
$requestData = json_decode(file_get_contents('php://input'));

// Créer la demande à envoyer à l'API avec la clé d'API
$apiRequest = curl_init('https://eligoal/e-veille/api/' . $requestData->endpoint);
curl_setopt($apiRequest, CURLOPT_RETURNTRANSFER, true);
curl_setopt($apiRequest, CURLOPT_CUSTOMREQUEST, $requestData->method);
curl_setopt($apiRequest, CURLOPT_POSTFIELDS, json_encode($requestData->data));
curl_setopt($apiRequest, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-API-KEY: ' . $apiKey, // Ajoutez la clé d'API ici
]);

// Envoyer la demande à l'API
$response = curl_exec($apiRequest);
curl_close($apiRequest);

// Retourner la réponse de l'API au front-enda
echo $response;
?>

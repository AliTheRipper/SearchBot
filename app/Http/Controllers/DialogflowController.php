<?php

namespace App\Http\Controllers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DialogflowController extends Controller
{
    public function index()
    {
        return view('dialogflow');
    }

    public function sendMessage(Request $request)
    {
        $queryText = $request->input('message');
        $projectId = env('DIALOGFLOW_PROJECT_ID');
        $sessionId = uniqid();
        $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');
        if (!file_exists($credentialsPath)) {
            die("Le fichier $credentialsPath n'existe pas.");
        }


        // URL de l'API REST de Dialogflow pour détecter l'intent
        $url = "https://dialogflow.googleapis.com/v2/projects/{$projectId}/agent/sessions/{$sessionId}:detectIntent";

        // Définir le scope pour obtenir le token d'accès
        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];

        // Créer les credentials à partir du fichier JSON du service account
        $credentials = new ServiceAccountCredentials($scopes, $credentialsPath);
        $token = $credentials->fetchAuthToken();

        if (!isset($token['access_token'])) {
            return response()->json(['reply' => 'Impossible de récupérer le token d\'accès.'], 500);
        }
        $accessToken = $token['access_token'];

        // Préparer le corps de la requête
        $body = [
            'queryInput' => [
                'text' => [
                    'text' => $queryText,
                    'languageCode' => 'fr'
                ]
            ]
        ];

        // Appeler l'API REST de Dialogflow avec Guzzle
        $client = new Client();
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type'  => 'application/json',
                ],
                'json' => $body
            ]);

            $replyData = json_decode($response->getBody()->getContents(), true);
            $reply = $replyData['queryResult']['fulfillmentText'] ?? 'Aucune réponse obtenue.';
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Erreur lors de l’appel à l’API : ' . $e->getMessage()], 500);
        }

        return response()->json(['reply' => $reply]);
    }
}

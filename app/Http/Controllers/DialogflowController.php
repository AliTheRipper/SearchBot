<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Google\Auth\Credentials\ServiceAccountCredentials;

class DialogflowController extends Controller
{
    public $webhookResponse = 'Aucune réponse de webhook reçue.';

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
            return response()->json(['reply' => 'Fichier credentials non trouvé.']);
        }

        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];
        $credentials = new ServiceAccountCredentials($scopes, $credentialsPath);
        $token = $credentials->fetchAuthToken();

        if (!isset($token['access_token'])) {
            return response()->json(['reply' => 'Impossible de récupérer le token.']);
        }

        $accessToken = $token['access_token'];

        $body = [
            'queryInput' => [
                'text' => [
                    'text' => $queryText,
                    'languageCode' => 'fr'
                ]
            ]
        ];

        $client = new Client();
        try {
            $response = $client->post(
                "https://dialogflow.googleapis.com/v2/projects/{$projectId}/agent/sessions/{$sessionId}:detectIntent",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$accessToken}",
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => $body
                ]
            );

            $replyData = json_decode($response->getBody(), true);

            $fulfillmentText = $replyData['queryResult']['fulfillmentText'] ?? 'Réponse vide.';
            $webhookPayload = $replyData['queryResult']['webhookPayload']['fields']['webhookResponse']['stringValue'] ?? 'Aucune réponse de webhook reçue.';

            return response()->json([
                'reply' => $fulfillmentText,
                'webhook_reply' => $webhookPayload,
            ]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Erreur API : ' . $e->getMessage()]);
        }
    }
}

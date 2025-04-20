<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Google\Auth\Credentials\ServiceAccountCredentials;
use App\Http\Controllers\TMDbController;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;


class DialogflowController extends Controller
{
    public function index()
    {
        return view('dialogflow');
    }

    public function sendMessage(Request $request)
    {
        $queryText = $request->input('message');
        $projectId = "cinebot-ixf9";
        $sessionId = uniqid();
        $credentialsPath = "/home/ibrahim/Documents/Gestion_des_Projets/SearchBot/cineBot_Back-end/dialogflow-key.json";// Chemin absolu vers le fichier de clé de compte de service
        //Remplacez la partie /home/ibrahim/Documents/Gestion_des_Projets/SearchBot/cineBot_Back-end/ par le chemin absolu vers votre fichier de clé de compte de service
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
            $reponse = $client->post(
                "https://dialogflow.googleapis.com/v2/projects/{$projectId}/agent/sessions/{$sessionId}:detectIntent",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$accessToken}",
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => $body
                ]
            );

            
            $replyData = json_decode($reponse->getBody(), true);
            $fulfillmentText = $replyData['queryResult']['fulfillmentText'] ?? 'Réponse vide.';
            $jsonArray = json_decode($fulfillmentText, true);

            $symfonyRequest = SymfonyRequest::create(
                '/fake-url',
                'POST',
                [],     // query parameters
                [],     // cookies
                [],     // files
                [],     // server
                json_encode($jsonArray) // contenu brut JSON
            );

            $laravelRequest = Request::createFromBase($symfonyRequest);
            $laravelRequest->headers->set('Content-Type', 'application/json');

            $tmdb = new TMDbController();
            $reponse = $tmdb->index($laravelRequest);

            $res = json_decode($reponse->getContent(), true);

            return response()->json([
                'movies' => array_map(function ($movie) {
                    return [
                        'id' => $movie['id'] ?? null,
                        'title' => $movie['title'] ?? null,
                        'original_language' => $movie['original_language'] ?? null,
                        'genres' => $movie['genres'] ?? [],
                        'overview' => $movie['overview'] ?? null,
                        'poster_path' => $movie['poster_path'] 
                            ? "https://image.tmdb.org/t/p/w500" . $movie['poster_path'] 
                            : null,
                        'release_date' => $movie['release_date'] ?? null,
                        'vote_average' => $movie['vote_average'] ?? null,
                        'actors' => $movie['actors'] ?? [] // Doit être ajouté dans TMDbController
                    ];
                }, $res)
            ]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Erreur API : ' . $e->getMessage()]);
        }
    }
}
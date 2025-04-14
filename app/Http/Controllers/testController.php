<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Film;
use App\Models\Movie;

class testController extends Controller
{
    public function message(){
        return "hello from comtroller!";
    }
    public function index()
    {
        
        return view('show');
    }

    public function show($id)
    {
        $film = Film::FindOrFail($id);
        return view('show', compact('film'));
    }

    public function create()
    {
        Film::create([
            'title'=>'Spider-man',
            'annee'=>'2001-06-12',
            'genre'=>'action',
            'note' => 5
        ]);
        return "film cree";
    }

    public function movie_create(Request $request)
    {
        $request->validate([
            'title'=>'require|string',
            'release_date'=>'require|date',
            'genre'=>'require|string',
            'rating'=>'require|numeric'
        ]);

        $movie =Movie::create($request->all());
        $movie->save();
        return response()->json($request->all(), 200);        
    }
    public function show_movie()
    {
        $movie = Movie::all();
        return $movie;
    }

    public function testAPI()
    {
        $allMovies= [];
        for($i = 1; $i <= 1 ; $i++)
        {
            $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR',
                'page' => $i
            ]);
            
            if ($response->successful()) {
                $movies = $response->json()['results'] ?? [];
    
                // Ajouter les films à la liste globale
                $allMovies = array_merge($allMovies, $movies);
            }
            
        }

        

        $filteredMovies = array_values(array_filter($allMovies, function ($movie) {
            return $movie['vote_average'] > 7;
        }));
    
        // Retourner la reponse JSON
        return response()->json($filteredMovies);

    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if(!$query)
        {
            return response()->json(['error' => 'veillez entrer le film que vous voulez'], 400);
        }

        $response = Http::get("https://api.themoviedb.org/3/search/movie", [
            'api_key' => '8b2be63b63004f08e7a50266f157e095',
            'query' => $query,
            'language' => 'fr-FR'
        ]);

        $movies = $response->json()['results']??[];
        return view('show', compact('movies'));
    }

    

    public function searchByJSON(Request $request)
    {
        

        $data = $request->json()->all();
        $movies = [];

        if (empty($data)) {
            return response()->json(['error' => 'Aucun critère reçu.'], 400);
        }
        

        // 1. Initialisation par critère principal (titre / acteur / genre)
        if (isset($data['titre'])) {
            // Recherche par titre
            $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'query' => $data['titre'],
                'language' => 'fr-FR'
            ]);
            $movies = $response->json()['results'] ?? [];
        
        } elseif (isset($data['name']) && isset($data['genre'])) {
            // Recherche combinee par acteur + genre
        
            // 1. Recuperer l’ID de l’acteur
            $searchResponse = Http::get("https://api.themoviedb.org/3/search/person", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'query' => $data['name'],
                'language' => 'fr-FR'
            ]);
            $searchData = $searchResponse->json();
        
            if (empty($searchData['results'])) {
                return response()->json(['error' => 'Acteur non trouve.'], 404);
            }
        
            $actorId = $searchData['results'][0]['id'];
        
            // 2. Recuperer les films de l’acteur
            $moviesResponse = Http::get("https://api.themoviedb.org/3/person/{$actorId}/movie_credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);
            $actorMovies = $moviesResponse->json()['cast'] ?? [];
        
            // 3. Recuperer la liste des genres pour trouver l’ID du genre
            $genreListResponse = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);
            $genres = $genreListResponse->json()['genres'] ?? [];
        
            $genreId = null;
            foreach ($genres as $genre) {
                if (strtolower($genre['name']) === strtolower($data['genre'])) {
                    $genreId = $genre['id'];
                    break;
                }
            }
        
            if (!$genreId) {
                return response()->json(['error' => 'Genre non trouve.'], 404);
            }
        
            // 4. Filtrer les films de l’acteur par genre
            $movies = array_filter($actorMovies, function ($movie) use ($genreId) {
                return isset($movie['genre_ids']) && in_array($genreId, $movie['genre_ids']);
            });
            
        
            $movies = array_values($movies);
        }
        elseif (isset($data['name'])) {
            $searchResponse = Http::get("https://api.themoviedb.org/3/search/person", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'query' => $data['name'],
                'language' => 'fr-FR'
            ]);
            $searchData = $searchResponse->json();

            if (empty($searchData['results'])) {
                return response()->json(['error' => 'Acteur non trouve.'], 404);
            }

            $actorId = $searchData['results'][0]['id'];

            $moviesResponse = Http::get("https://api.themoviedb.org/3/person/{$actorId}/movie_credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);

            $movies = $moviesResponse->json()['cast'] ?? [];

        } elseif (isset($data['genre'])) {
            $genreListResponse = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);

            $genres = $genreListResponse->json()['genres'] ?? [];

            $genreId = null;
            foreach ($genres as $genre) {
                if (strtolower($genre['name']) === strtolower($data['genre'])) {
                    $genreId = $genre['id'];
                    break;
                }
            }

            if (!$genreId) {
                return response()->json(['error' => 'Genre non trouve.'], 404);
            }

            $genreMoviesResponse = Http::get("https://api.themoviedb.org/3/discover/movie", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'with_genres' => $genreId,
                'language' => 'fr-FR'
            ]);

            $movies = $genreMoviesResponse->json()['results'] ?? [];

        } else {
            if (isset($data['vote_average']) || isset($data['original_language']) || isset($data['gender'])) {
                $movies = [];
            
                for ($page = 1; $page <= 2; $page++) {
                    $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                        'api_key' => '8b2be63b63004f08e7a50266f157e095',
                        'page' => $page
                    ]);
            
                    $moviesOnPage = $response->json()['results'] ?? [];
                    $movies = array_merge($movies, $moviesOnPage);
                }
            
                $movies = array_filter($movies, function ($movie) use ($data) {
                    $isValid = true;
            
                    if (isset($data['vote_average'])) {
                        $isValid = $isValid && isset($movie['vote_average']) && $movie['vote_average'] >= $data['vote_average'];
                    }
            
                    if (isset($data['original_language'])) {
                        $isValid = $isValid && isset($movie['original_language']) && $movie['original_language'] === $data['original_language'];
                    }
            
                    return $isValid;
                });
            
                $movies = array_values($movies); // Reindexer
            
                if ($data['mainActor'] == 'true') {
                    $filtered = [];
            
                    foreach ($movies as $movie) {
                        $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/credits", [
                            'api_key' => '8b2be63b63004f08e7a50266f157e095'
                        ]);
            
                        $credits = $creditsResponse->json();
                        $cast = $credits['cast'] ?? [];
            
                        if (!empty($cast) && isset($cast[1]['gender']) && $cast[1]['gender'] == $data['gender']) {
                            $movie['main_actor'] = $cast[1]['name'];
                            $filtered[] = $movie;
                        }
                    }
            
                    $movies = $filtered;
                }
            }else {
                return response()->json(['error' => 'Aucun critère principal fourni.'], 400);
            }
        }
        

        // 2. Filtrer par langue d'origine
        if (isset($data['original_language'])) {
            $movies = array_filter($movies, function ($movie) use ($data) {
                return isset($movie['original_language']) && $movie['original_language'] === $data['original_language'];
            });
        }

        // 3. Filtrer par vote minimum
        if (isset($data['vote_average'])) {
            $movies = array_filter($movies, function ($movie) use ($data) {
                return isset($movie['vote_average']) && $movie['vote_average'] >= $data['vote_average'];
            });
        }

        // 4. Filtrer par genre de l'acteur principal
        if (isset($data['gender'])) {
            $filtered = [];
            foreach ($movies as $movie) {
                $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/credits", [
                    'api_key' => '8b2be63b63004f08e7a50266f157e095'
                ]);

                $credits = $creditsResponse->json();
                $cast = $credits['cast'] ?? [];

                if (!empty($cast) && isset($cast[0]['gender']) && $cast[0]['gender'] == $data['gender']) {
                    $movie['main_actor'] = $cast[0]['name'];
                    $filtered[] = $movie;
                }
            }
            $movies = $filtered;
        }

        if (isset($data['periode'])) {
            $periode = strtolower($data['periode']);
            $startYear = 0;
            $endYear = 9999;
        
            switch ($periode) {
                case 'années 90':
                    $startYear = 1990;
                    $endYear = 1999;
                    break;
                case 'années 2000':
                    $startYear = 2000;
                    $endYear = 2009;
                    break;
                case 'annés 2010':
                    $startYear = 2010;
                    $endYear = 2019;
                    break;
                case 'années 2020':
                    $startYear = 2020;
                    $endYear = 2029;
                    break;
                // Tu peux rajouter d'autres periodes ici
            }
        
            $movies = array_filter($movies, function ($movie) use ($startYear, $endYear) {
                if (!isset($movie['release_date']) || empty($movie['release_date'])) {
                    return false;
                }
                $year = intval(substr($movie['release_date'], 0, 4));
                return $year >= $startYear && $year <= $endYear;
            });
        
            $movies = array_values($movies);
        }

        // 5. Ajouter les noms des acteurs (optionnel)
        $moviesWithActors = [];
        foreach ($movies as $movie) {
            $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095'
            ]);
            $credits = $creditsResponse->json();
            $movie['actors'] = array_column($credits['cast'] ?? [], 'name');
            $moviesWithActors[] = $movie;
        }

        return response()->json(array_values($moviesWithActors));

    }


    public function getMoviesByActor(Request $request)
    {
        $actorName = $request->json()->all();

        if (!$actorName) {
            return response()->json(['error' => 'Veuillez fournir un nom d\'acteur.'], 400);
        }

        $searchResponse = Http::get("https://api.themoviedb.org/3/search/person", [
            'api_key' => '8b2be63b63004f08e7a50266f157e095', 
            'query' => $actorName['name'],
            'language' => 'fr-FR'
        ]);

        $searchData = $searchResponse->json();

        if (empty($searchData['results'])) {
            return response()->json(['error' => 'Acteur non trouve.'], 404);
        }

        $actorId = $searchData['results'][0]['id'];

        $moviesResponse = Http::get("https://api.themoviedb.org/3/person/{$actorId}/movie_credits", [
            'api_key' => '8b2be63b63004f08e7a50266f157e095',
            'language' => 'fr-FR'
        ]);

        $movieData = $moviesResponse->json();

        $movies = $movieData['cast'] ?? [];


        return response()->json([
            'acteur' => $actorName['name'],
            'nombre_de_films' => count($movies),
            'films' => $movies
        ]);
    }

    /*$data = $request->json()->all();

        if(!isset($data['titre']))
        {
            return response()->json(['error'=>'titre manquant',400]);
        }else{
            $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'query' => $data['titre'],
                'language' => 'fr-FR'
            ]);
    
            $movies = $response->json()['results'] ?? [];
        }

        if(!isset($data['name']))
        {
            return response()->json(['error' => 'Veuillez fournir un nom d\'acteur.'], 400);

        }else{
            $searchResponse = Http::get("https://api.themoviedb.org/3/search/person", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095', 
                'query' => $data['name'],
                'language' => 'fr-FR'
            ]);
    
            $searchData = $searchResponse->json();

            if (empty($searchData['results'])) {
                return response()->json(['error' => 'Acteur non trouve.'], 404);
            }
    
            $actorId = $searchData['results'][0]['id'];
    
            $moviesResponse = Http::get("https://api.themoviedb.org/3/person/{$actorId}/movie_credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);
    
            $movieData = $moviesResponse->json();
    
            $movies = $movieData['cast'] ?? [];
        }
        

        $filteredMovies = array_filter($movies, function($movie) use($data){
            return $movie['original_language']===$data['original_language'];
        });

        $moviesWithActors= [];

        foreach ($filteredMovies as $movie) {
            $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095'
            ]);
    
            $credits = $creditsResponse->json();
            /*$actors = $credits['cast'] ?? [];
    
            $movie['actors'] = array_slice(array_column($actors, 'name'), 0, 5);
            $movie['actors'] = $credits['cast'] ?? [];

            $moviesWithActors[] = $movie;
        }
    
        return response()->json(array_values($moviesWithActors));


        //stocker les donnee envoyer par le chatbot sous forme JSON
        $data = $request->json()->all();
        //stocker les films recherchee
        $movies = [];

        // chercher par titre
        if (isset($data['titre'])) {
            //Requete pour avoir l'acces a TMDB par methode get
            $response = Http::get("https://api.themoviedb.org/3/search/movie", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'query' => $data['titre'],
                'language' => 'fr-FR'
            ]);

            //stocker les films trouve dans la liste resultat sinon renvoyer [] (vide)
            $movies = $response->json()['results'] ?? [];
        }

        // chercher par nom d'acteur
        if (isset($data['name'])) {
            $searchResponse = Http::get("https://api.themoviedb.org/3/search/person", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'query' => $data['name'],
                'language' => 'fr-FR'
            ]);

            $searchData = $searchResponse->json();

            //si rien n'ai trouve envoyer un message JSON
            if (empty($searchData['results'])) {
                return response()->json(['error' => 'Acteur non trouve.'], 404);
            }

            //stocker la valeur id d'acteur
            $actorId = $searchData['results'][0]['id'];

            $moviesResponse = Http::get("https://api.themoviedb.org/3/person/{$actorId}/movie_credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);

            $actorMovies = $moviesResponse->json()['cast'] ?? [];

            // intersection de la table film cherchee (si trouvee) et le tableau des acteur
            if (!empty($movies)) {
                $movies = array_filter($movies, function ($movie) use ($actorMovies) {
                    return in_array($movie['id'], array_column($actorMovies, 'id'));
                });

            }
            //sinon que les acteur 
            else {
                $movies = $actorMovies;
            }
        }

        if (isset($data['genre'])) {
            // Recupere la liste des genres
            $genreListResponse = Http::get("https://api.themoviedb.org/3/genre/movie/list", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'language' => 'fr-FR'
            ]);
        
            $genres = $genreListResponse->json()['genres'] ?? [];
        
            // Trouve l'ID correspondant au nom du genre
            $genreId = null;
            foreach ($genres as $genre) {
                if (strtolower($genre['name']) === strtolower($data['genre'])) {
                    $genreId = $genre['id'];
                    break;
                }
            }
        
            if (!$genreId) {
                return response()->json(['erreur' => 'Genre non trouve.'], 404);
            }
        
            // Recupere les films par genre via /discover/movie
            $genreMoviesResponse = Http::get("https://api.themoviedb.org/3/discover/movie", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095',
                'with_genres' => $genreId,
                'language' => 'fr-FR'
            ]);
        
            $genreMovies = $genreMoviesResponse->json()['results'] ?? [];
        
            // Fusionner ou filtrer avec les $movies precedents
            if (!empty($movies)) {
                $movies = array_filter($movies, function ($movie) use ($genreMovies) {
                    return in_array($movie['id'], array_column($genreMovies, 'id'));
                });
            } else {
                $movies = $genreMovies;
            }
        }
        

        // filtrer les films par la langue d'origine
        if (isset($data['original_language'])) {
            $filteredByGender = [];
            $movies = [];
        
            // Boucle pour recuperer les 10 premier page trouve
            for ($page = 1; $page <= 10; $page++) {
                $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                    'api_key' => '8b2be63b63004f08e7a50266f157e095',
                    'page' => $page
                ]);
        
                $moviesOnPage = $response->json()['results'] ?? [];
        
                //fusionne les filmes cherhche par d'autre critere avec ceux qui sont filtre par langue
                $movies = array_merge($movies, $moviesOnPage);
            }
            //condition de filtrage
            $movies = array_filter($movies, function ($movie) use ($data) {
                return $movie['original_language'] === $data['original_language'];
            });
        
            // Reindexer les resultats filtres
            $movies = array_values($movies); 
            
        }

        //filtrer par la note (on garde les films avec une note sup que ce que utilisateur demande)
        if (isset($data['vote_average'])) {
            $filteredByGender = [];
            $movies = [];
        
            for ($page = 1; $page <= 10; $page++) { 
                $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                    'api_key' => '8b2be63b63004f08e7a50266f157e095',
                    'page' => $page
                ]);
        
                $moviesOnPage = $response->json()['results'] ?? [];
        
                $movies = array_merge($movies, $moviesOnPage);
            }
        
            $movies = array_filter($movies, function ($movie) use ($data) {
                return $movie['vote_average'] >= $data['vote_average'];
            });
        
            $movies = array_values($movies);  
        }
        

        // Filtrer par genre d'acteur principale
        if (isset($data['gender'])) {
            $filteredByGender = [];
            $movies = [];
        
            for ($page = 1; $page <= 1; $page++) {
                $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
                    'api_key' => '8b2be63b63004f08e7a50266f157e095',
                    'page' => $page
                ]);
        
                $moviesOnPage = $response->json()['results'] ?? [];
        
                $movies = array_merge($movies, $moviesOnPage);
            }
        
            // Appliquer le filtre par genre sur les films recuperee
            foreach ($movies as $movie) {
                $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/credits", [
                    'api_key' => '8b2be63b63004f08e7a50266f157e095'
                ]);
            
                $credits = $creditsResponse->json();
                $cast = $credits['cast'] ?? [];
            
                if (!empty($cast)) {
                    // Verification de cast[0] et cast[1]
                    $mainActor = null;
                    $secondaryActor = null;
            
                    // Verifier cast[0] (acteur principal)
                    if (isset($cast[0])) {
                        $mainActor = $cast[0];
                    }
            
                    // Verifier cast[1] (acteur secondaire)
                    if (isset($cast[1])) {
                        $secondaryActor = $cast[1];
                    }
            
                    // Verifier les genres des acteurs
                    $actorsToAdd = [];
            
                    if ($mainActor && isset($mainActor['gender']) && $mainActor['gender'] == $data['gender']) {
                        $actorsToAdd[] = $mainActor['name'];
                    }
            
                    if ($secondaryActor && isset($secondaryActor['gender']) && $secondaryActor['gender'] == $data['gender']) {
                        $actorsToAdd[] = $secondaryActor['name'];
                    }
            
                    // Si au moins un acteur correspond au genre, ajouter le film a la liste filtree
                    if (!empty($actorsToAdd)) {
                        $movie['main_actor'] = $mainActor ? $mainActor['name'] : null;
                        $movie['secondary_actor'] = $secondaryActor ? $secondaryActor['name'] : null;
                        $filteredByGender[] = $movie;
                    }
                }
            }
        
            // Si aucun film ne correspond au filtre de genre, renvoyer un message d'erreur
            if (empty($filteredByGender)) {
                return response()->json(['message' => 'No movies match the gender filter'], 404);
            }
        
            // Retourner les films filtres
            $movies = $filteredByGender;
        }
        

        // rajouter les acteur (optionnelles)
        $moviesWithActors = [];
        foreach ($movies as $movie) {
            $creditsResponse = Http::get("https://api.themoviedb.org/3/movie/{$movie['id']}/credits", [
                'api_key' => '8b2be63b63004f08e7a50266f157e095'
            ]);

            $credits = $creditsResponse->json();
            $movie['actors'] = array_column($credits['cast'] ?? [], 'name');
            $moviesWithActors[] = $movie;
        }

        


        return response()->json(array_values($moviesWithActors));*/

}

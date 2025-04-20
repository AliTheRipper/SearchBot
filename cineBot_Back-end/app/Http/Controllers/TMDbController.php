<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TMDbController extends Controller
{
    protected $apiKey = '8b2be63b63004f08e7a50266f157e095';
    protected $baseUrl = 'https://api.themoviedb.org/3';

    protected $genreMap = [
        'ACTION'            => 28,
        'ADVENTURE'         => 12,
        'ANIMATION'         => 16,
        'COMEDY'            => 35,
        'CRIME'             => 80,
        'DOCUMENTARY'       => 99,
        'DRAMA'             => 18,
        'FAMILY'            => 10751,
        'FANTASY'           => 14,
        'HISTORY'           => 36,
        'HORROR'            => 27,
        'MUSIC'             => 10402,
        'MYSTERY'           => 9648,
        'ROMANCE'           => 10749,
        'SCIENCE-FICTION'   => 878,
        'TV MOVIE'          => 10770,
        'THRILLER'          => 53,
        'WAR'               => 10752,
        'WESTERN'           => 37,
    ];

    protected $defaults = [
        'title'             => 'null',
        'name'              => 'null',
        'periode'           => 'null',
        'genre'             => 'null',
        'gender'            => '2',
        'mainActor'         => 'true',
        'vote_average'      => '7.0',
        'original_langauge' => 'en',
    ];

    private function getGenreId(string $genre): ?int
    {
        $key = strtoupper(trim($genre));
        return $this->genreMap[$key] ?? null;
    }

    public function index(Request $request)
    {
        $data = $request->only([
            'title', 'name', 'periode', 'genre',
            'gender', 'mainActor', 'vote_average', 'original_langauge'
        ]);

        $filters = [];
        foreach ($data as $k => $v) {
            if ($v === null || $v === '' || strtolower($v) === 'null') {
                continue;
            }
            if (isset($this->defaults[$k]) && (string)$v === $this->defaults[$k]) {
                continue;
            }
            $filters[$k] = $v;
        }

        $genreIds = [];
        if (!empty($filters['genre'])) {
            // Séparation intelligente par "et", ",", "and"
            $splitGenres = preg_split('/[\s,]*et[\s,]*|[\s,]*and[\s,]*|,/', $filters['genre']);
            foreach ($splitGenres as $g) {
                $id = $this->getGenreId($g);
                if ($id) {
                    $genreIds[] = $id;
                }
            }
        }

        $movies = [];

        // Recommandation de film similaire
        if (!empty($filters['title'])) {
            $search = Http::get("{$this->baseUrl}/search/movie", [
                'api_key'  => $this->apiKey,
                'query'    => $filters['title'],
                'language' => 'fr-FR',
                'page'     => 1,
            ])->json();

            if (!empty($search['results'])) {
                $id = $search['results'][0]['id'];
                $movies = Http::get("{$this->baseUrl}/movie/{$id}/similar", [
                    'api_key'  => $this->apiKey,
                    'language' => 'fr-FR',
                    'page'     => 1,
                ])->json()['results'] ?? [];
            }
        }
        // Discover avec critères combinés
        else {
            $query = [
                'api_key'  => $this->apiKey,
                'language' => 'fr-FR',
                'page'     => 1,
            ];

            // Acteur
            if (!empty($filters['name'])) {
                $person = Http::get("{$this->baseUrl}/search/person", [
                    'api_key'  => $this->apiKey,
                    'query'    => $filters['name'],
                    'language' => 'fr-FR',
                    'page'     => 1,
                ])->json()['results'][0] ?? null;

                if ($person) {
                    $query['with_cast'] = $person['id'];
                }
            }

            // Genres multiples
            if (!empty($genreIds)) {
                $query['with_genres'] = implode(',', $genreIds);
            }

            // Note minimale
            if (!empty($filters['vote_average'])) {
                $query['vote_average.gte'] = (float)$filters['vote_average'];
            }

            // Période
            if (!empty($filters['periode']) && preg_match('/(\d{4})/', $filters['periode'], $y)) {
                $start = $y[1];
                $query['primary_release_date.gte'] = "{$start}-01-01";
                $query['primary_release_date.lte'] = ($start + 9) . "-12-31";
            }

            // Langue originale
            if (!empty($filters['original_langauge'])) {
                $query['with_original_language'] = strtolower($filters['original_langauge']);
            }

            // Exécution
            $query = array_filter($query, fn($v) => $v !== null && $v !== '');
            $movies = Http::get("{$this->baseUrl}/discover/movie", $query)
                          ->json()['results'] ?? [];
        }

        if (empty($movies)) {
            return response()->json(['message' => 'Aucun résultat trouvé'], 404);
        }

        return response()->json($this->formatMovies($movies));
    }

    private function formatMovies(array $movies): array
    {
        $gm = Http::get("{$this->baseUrl}/genre/movie/list", [
            'api_key'  => $this->apiKey,
            'language' => 'fr-FR',
        ])->json()['genres'] ?? [];

        $nameById = [];
        foreach ($gm as $g) {
            $nameById[$g['id']] = $g['name'];
        }

        $out = [];
        foreach ($movies as $m) {
            $cast = Http::get("{$this->baseUrl}/movie/{$m['id']}/credits", [
                'api_key' => $this->apiKey,
            ])->json()['cast'] ?? [];

            $m['actors'] = array_column($cast, 'name');

            $m['genres'] = [];
            foreach ($m['genre_ids'] ?? [] as $gid) {
                if (isset($nameById[$gid])) {
                    $m['genres'][] = $nameById[$gid];
                }
            }

            $out[] = $m;
        }

        return $out;
    }
}

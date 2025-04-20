
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>CineBot</title>
    </head>
    <body>
        <h1>Recherche le film que tu veux!!</h1>
        <form action = "{{route('movie.search')}}" methode="POST">
            <input type="text" name="query" placeholder="Ecrivez le film">
            <button type="submit">Recherche</button>
        </form>

        @if(isset($movies))
            <h2>Resultat : </h2>
            <ul>
                @foreach($movies as $movie)
                    <li>{{$movie['title']}} ({{$movie['release_date'] ?? 'date inconue'}})</li>
                @endforeach
            </ul>
        @endif
    </body>
</html>


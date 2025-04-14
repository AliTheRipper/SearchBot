<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>CHOIX DU FILM</title>
    </head>
    <body>
        <h1>Choisi le film que tu veux!</h1>
        <button onclick = "window.location.href='/films/{{$film1->id}}';">
            {{$film1->titre}}
        </button>
        <button onclick = "window.location.href='/films/{{$film2->id}}';">
            {{$film2->titre}}
        </button>
        <button onclick = "window.location.href='/films/{{$film3->id}}';">
            {{$film3->titre}}
        </button>
        <button onclick = "window.location.href='/films'">
            cree un nouveau film
        </button>
    </body>
</html>
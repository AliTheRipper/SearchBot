<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Dialogflow</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Test Dialogflow avec Laravel</h2>
    <textarea id="message" placeholder="Écris ta requête ici..." oninput="adjustHeight(this)"></textarea>

    <script>
    function adjustHeight(el) {
        el.style.height = 'auto'; // Réinitialiser la hauteur avant de recalculer
        el.style.height = (el.scrollHeight) + 'px'; // Ajuster la hauteur au contenu
    }
    </script>
    <button onclick="sendMessage()">Envoyer</button>
    <p><strong>Réponse de l'agent :</strong> <span id="response"></span></p>
    <script>
        function sendMessage() {
            var message = $('#message').val();
            $.ajax({
                url: '/send-message',
                method: 'POST',
                data: { message: message, _token: '{{ csrf_token() }}' },
                success: function(response) {
    $('#response').html('<strong>Requête JSON :</strong> ' + response.reply);

    if (response.movies && response.movies.length > 0) {
        let html = '<ul>';
        response.movies.forEach(function(movie) {
            html += '<li><strong>' + movie.title + '</strong> (' + movie.release_date + ') - Note : ' + movie.vote_average + '</li>';
        });
        html += '</ul>';
        $('#response').append('<br><strong>Films trouvés :</strong><br>' + html);
    } else {
        $('#response').append('<br><em>Aucun film trouvé.</em>');
    }
},
                error: function(xhr) {
                    alert('Erreur : ' + xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>

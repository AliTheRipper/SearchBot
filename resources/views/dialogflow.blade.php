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
    <input type="text" id="message" placeholder="Écris ta requête ici...">
    <button onclick="sendMessage()">Envoyer</button>
    <p>Réponse : <span id="response"></span></p>

    <script>
        function sendMessage() {
            var message = $('#message').val();
            $.ajax({
                url: '/send-message',
                method: 'POST',
                data: { message: message, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    $('#response').text(response.reply);
                }
            });
        }
    </script>
</body>
</html>

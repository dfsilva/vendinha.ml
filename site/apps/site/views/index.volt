<!DOCTYPE html>
<html>
    <head>
        <title>Phalcon PHP Framework</title>

        <script src="https://www.gstatic.com/firebasejs/5.5.9/firebase.js"></script>
        <script>
            // Initialize Firebase
            var config = {
                apiKey: "AIzaSyCDexpwdcBfdZbBsT0piHG3EsJc1YtrlGI",
                authDomain: "vendinhaml.firebaseapp.com",
                databaseURL: "https://vendinhaml.firebaseio.com",
                projectId: "vendinhaml",
                storageBucket: "vendinhaml.appspot.com",
                messagingSenderId: "549395679035"
            };
            firebase.initializeApp(config);
        </script>
    </head>
    <body>
        {{ content() }}
    </body>
</html>
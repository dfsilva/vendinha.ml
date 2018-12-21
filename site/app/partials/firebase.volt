<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-auth.js"></script>
<script>
    var config = {
        apiKey: {{ constant("FIB_API_KEY") }}
        authDomain: {{ constant("FIB_AUTH_DOMAIN") }}
        databaseURL: {{ constant("FIB_DB_URL") }}
        projectId: {{ constant("FIB_PJ_ID") }}
        storageBucket: {{ constant("FIB_ST_BUCKET") }}
        messagingSenderId: {{ constant("FIB_MSG_SENDER_ID") }}
    };
    firebase.initializeApp(config);
</script>
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/5.5.9/firebase-auth.js"></script>
<script>
    var config = {
        apiKey: <?=FIB_API_KEY?>
        authDomain: <?=FIB_AUTH_DOMAIN?>
        databaseURL: <?=FIB_DB_URL?>
        projectId: <?=FIB_PJ_ID?>
        storageBucket: <?=FIB_ST_BUCKET?>
        messagingSenderId: <?=FIB_MSG_SENDER_ID?>
    };
    firebase.initializeApp(config);
</script>
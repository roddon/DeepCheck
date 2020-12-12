<span id="recaptcha-container" data-sitekey="6LeHF78ZAAAAAMpuCPGIjj9U7ZEpO1tvm63ztBWR"></span>

<!-- <script src="https://www.google.com/recaptcha/api.js?render=6LeHF78ZAAAAAMpuCPGIjj9U7ZEpO1tvm63ztBWR"></script> -->
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-app.js"></script>

<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-analytics.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.18.0/firebase-functions.js"></script>

<script>
    const firebaseConfig = {
        apiKey: "AIzaSyCY00t93feq0cn8D8LK4OdLMFtAXo1WXq0",
        authDomain: "deepcheckone-c38cb.firebaseapp.com",//"deepcheck-6a6a9.firebaseapp.com",
        databaseURL: "https://deepcheckone-c38cb.firebaseio.com",//"https://deepcheck-6a6a9.firebaseio.com",
        projectId: "deepcheckone-c38cb",//"deepcheck-6a6a9",
        storageBucket: "deepcheckone-c38cb.appspot.com",//"deepcheck-6a6a9.appspot.com",
        messagingSenderId: "712005591264",
        appId: "1:712005591264:web:3174869022cebfefc5f085",
        measurementId: "G-BJLY5STVZZ"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // This will resolve after rendering without app verification.
    var appVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
    });
</script>
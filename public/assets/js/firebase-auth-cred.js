
(function (){
  var admin = require("firebase-admin");

  var serviceAccount = require("../projeto-614bd-firebase-adminsdk-7aert-6193717049.json");

  admin.initializeApp({
    credential: admin.credential.cert(serviceAccount),
    databaseURL: "https://projeto-614bd-default-rtdb.europe-west1.firebasedatabase.app"
  });

  
  firebase.initializeApp(firebaseConfig);

  $(".register form").on("submit", function(event){
    event.preventDefault();

    var email = $(".register .email").val();
    var password = $(".register .password").val();

    firebase.auth().createUserWhitEmailAndPassword(email,password)
    .then(function(params) {
      console.log(params);
      
    }).catch(function(err){
      console.log(err);
    });
  });

  $(".login form").on("submit", function(event){
    event.preventDefault();
    var email = $(".login .email").val();
    var password = $(".login .password").val();
    firebase.auth().signInWithEmailAndPassword(email,password)
    .then(function(params) {
      console.log(params);
      
    }).catch(function(err){
      console.log(err);
    });

  });

})();
 
 
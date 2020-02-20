$('#envoi').click(function(e){
    e.preventDefault(); // on empêche le bouton d'envoyer le formulaire

    var pseudo = encodeURIComponent( $('#pseudo').val() ); // on sécurise les données
    var message = decodeURI( $('#message').val() );

    if(pseudo != "" && message != ""){ // on vérifie que les variables ne sont pas vides
        $.ajax({
            url : "traitement.php", // on donne l'URL du fichier de traitement
            type : "POST", // la requête est de type POST
            data : "pseudo=" + pseudo + "&message=" + message // et on envoie nos données
        });

       $('#messages').append("<p>" + pseudo + " dit : " + message + "</p>"); // on ajoute le message dans la zone prévue
    }
});

function charger(){

    setTimeout( function(){

        var premierID = $('#messages p:first').attr('id'); // on récupère l'id le plus récent

        $.ajax({
            url : "charger.php?id=" + premierID, // on passe l'id le plus récent au fichier de chargement
            type : GET,
            success : function(html){
                $('#messages').prepend(html);
            }
        });

        charger();

    }, 5000);

}

charger();



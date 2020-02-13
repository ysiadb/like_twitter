<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Test TWEET</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>TWEET ACADEMIE</h1>
        </header>
        <div class="profil">
            <h2>Bienvenue <?php echo $_SESSION["pseudo"]; ?> </h2>
            <br/>
            <h3>Tweet</h3>
            <form action="" name="twitter" method="post">
                <button>S'abonner</button>
                <br/>
                <textarea id="tweet" placeholder="Votre message ..." name="tweet" rows="10" cols="50"></textarea>
                <br/><br/>
                <input type="submit" name="envoyer" value="Envoyer">
                <br/><br/>
                <?php include ("poo_tweet.php");?>
            </form>
        </div>
    </body>
</html>
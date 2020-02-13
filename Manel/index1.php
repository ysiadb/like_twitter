<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>TWEET ACADEMIE</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div class="connexion">
            <h3>Connexion</h3>
            <form action ="" method="post">
                <input type="text" name="prenom" placeholder="Prenom">
                <input type="text" name="pseudo" placeholder="Pseudo">
                <input type="submit" name="connexion" value="Se connecter">
                <?php
                include('connexion.php');
                ?>
            </form>
        </div>
    </body>
</html> 
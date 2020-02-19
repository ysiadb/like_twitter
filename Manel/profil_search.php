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
        <div>
        <?php

        include("recherche.php");

        while($select_search = $reqS->fetch())
        {
            echo "<div><a href='profil.php'><p>".$select_search['pseudo']."</p></a><div>";
        }
        ?>
        </div>
    </body>
</html>
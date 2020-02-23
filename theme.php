<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


function theme()
{
    global $bdd;
    $theme = $bdd->prepare('SELECT theme from user where id_user = ?');
    $theme->execute(array($_SESSION['id_user']));

    $code = ['#ffffff', '#1abc9c', '#f1c40f', '#40d47e'];
    echo "<script>document.body.style.backgroundColor = " . $code[$theme] . ";";
}

<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


// function theme()
// {
//     global $bdd;
//     $theme = $bdd->prepare('SELECT theme from user where id_user = ?');
//     $theme->execute(array($_SESSION['id_user']));

//     $code = ['#bdc3c7', '#1abc9c', '#f1c40f', '#40d47e'];
//     echo "<script>document.body.style.backgroundColor = " . $code[$theme] . ";";
// }

function theme()
{
   global $bdd;
   $theme = $bdd->prepare('SELECT theme from user where id_user = ?');
   $theme->execute(array($_SESSION['id_user']));
   $number = $theme->fetchAll();

   $code = ['#bdc3c7', '#1abc9c', '#f1c40f', '#40d47e'];
   echo "<script>document.body.style.backgroundColor = '" . $code[$number[0][0]] . "';</script>";
}

if (isset($_GET['id_user']) and $_GET['id_user'] > 0) {
   $getid = intval($_GET['id_user']);
   $requser = $bdd->prepare('SELECT * FROM user WHERE id_user = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
}
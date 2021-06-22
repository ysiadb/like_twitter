<?php

    session_start();
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
     } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
     }


     $getfollowedid = intval($_GET['id_followed']);
     $suiveur = $_SESSION['id_user'];
     $suivi = $_GET['id_user'];

     if($getfollowedid != $_SESSION['id_user'])
     {
        echo "Ok";
        $dejafollowed = $bdd->prepare('SELECT * FROM follow WHERE id_followed = ? AND id_follower = $suiveur');
        $dejafollowed->execute(array($suiveur, $getfollowedid));
        $dejafollowed = $dejafollowed->rowCount();

        if($dejafollowed == 0)
        {
            $addfollow = $bdd->prepare('INSERT INTO follow(id_follower, id_followed) VALUES(?, ?)');
            $addfollow->execute(array($suiveur, $getfollowedid));
        }



    }
    header('Location:'.$_SERVER['HTTP_REFERER']);

?>

<!DOCTYPE html>
<html>

<head>
   <!-- BASICS 
    ______________________________-->

   <meta charset="UTF-8">
   <title>Tweet_Academie</title>

   <!-- CSS 
    ______________________________-->

   <link rel="stylesheet" type="text/css" href="/css/style.css">
   <link rel="stylesheet" href="https://use.typekit.net/gsh6pdg.css">
   <link rel="stylesheet" type="text/css" href="/css/normalize.css">
   <link rel="stylesheet" type="text/css" href="/css/skeleton.css">

   <!-- MOBILE SPECIFIC METAS 
    ______________________________-->
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- FONT 
    ______________________________-->

   <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

   <!-- FAVICON 
    ______________________________-->

   <link rel="icon" type="image/png" href="images/favicon.png">
</head>

<?php
session_start();

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
   $number = $theme->fetchAll();

   $code = ['#bdc3c7', '#1abc9c', '#f1c40f', '#40d47e'];
   echo "<script>document.body.style.backgroundColor = '" . $code[$number[0][0]] . "';</script>";
}

if (isset($_GET['id_user']) and $_GET['id_user'] > 0) {
   $getid = intval($_GET['id_user']);
   $requser = $bdd->prepare('SELECT * FROM user WHERE id_user = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();


?>

   <body>
      <div class="container">
         <div class="header_ban">
            <div class="row">
               <div class="six columns">
                  <a href="index.php"><img id="logo" src="/twitter-logo.png" alt="logo" style="width:30%"></a>
               </div>
               <div class="six columns right_menu">
                  <a href="edit-profil.php" style="color:white">Editer mon profil</a>
                  <a href="deconnexion.php" style="color:white">Se déconnecter</a>

               </div>
            </div>
         </div>

         <div class="row">

            <div class="one column menu">
               <div class="left_menu">
                  <a href="index.php"><img src="/MISC/home.png" alt="Accueil"></a>
                  <a href=""><img src="/MISC/hashtag.png" alt="#Explorer"></a>
                  <a href=""><img src="/MISC/notif.png" alt="Notifications"></a>
                  <a href=""><img src="/MISC/message.png" alt="Message"></a>
                  <a href="profil.php?id_user=<?= $_SESSION['id_user'] ?>"><img src="/MISC/profil.png" alt="Profil"></a>
               </div>
               <button method="get" name="t" value="Tweeter">Tweeter</button>
            </div>


            <div class="eight columns center">
                  <div>
                     <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
                     <div class="info">
                        <h5>Infos</h5>
                        <img src="femme_sourire.jpg" alt="pp" id="pp">
                        Pseudo : <?php echo $userinfo['pseudo']; ?>
                        <br />
                        Mail : <?php echo $userinfo['email']; ?>
                     </div>
                     <hr>
                     <br />
                     <?php
                     if (isset($_SESSION['id_user']) and $userinfo['id_user'] == $_SESSION['id_user']) {
                     ?>
                        <br />
                     <?php
                     }
                     ?>
                  </div>
                  <div class="row">
                    <div class="add_tweet">
                        <img src="femme_sourire.jpg" alt="pp">
                        <form action="" name="twitter" method="post">
                                <textarea id="tweet" placeholder="Quoi de neuf ?" name="tweet" rows="10" cols="50"></textarea>
                                <br />
                            <input id="button" type="submit" name="envoyer" value="Envoyer">
                        </form>
                    </div>
                    <hr>
                  </div>
                  <br />

                    <div class="timeline">
                       <?php include('poo_tweet.php'); ?>
                    </div>
                </div>


            <div class="two columns search">
               <div class="search_leftarea">
                  <form action="search.php" method="get">
                     <input placeholder="Rechercher..." id="site-search" name="terme" aria-label="Search through site content">
                     <button method="get" name="q" value="Rechercher">Go</button>
                  </form>
               </div>
            </div>

         </div>
         <?php theme(); ?>
   </body>

   <script type="text/javascript" src="auto-refresh.js"></script>
</html>

<?php } ?>
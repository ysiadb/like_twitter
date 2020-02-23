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
   $number = $theme->fetch();

   $code = ['#ffffff', '#1abc9c', '#f1c40f', '#40d47e'];
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
               <a href="index.php"><img id="logo" src="/tweetacademiee.png" alt="logo" style="width:50%"></a>
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
                  <a href=""><img src="/MISC/message.png" alt="Message"></a>
                  <a href="profil.php?id_user=<?= $_SESSION['id_user'] ?>"><img src="/MISC/profil.png" alt="Profil"></a>
               </div>
               <button method="get" name="t" value="Tweeter">Tweeter</button>
            </div>


            <div class="eight columns center">
                  <div>
                     <?php echo '<b style="color : #33ccff; font-size : 40px;">'. $userinfo['surname']. '</b>' ." • ". '<i>' .$userinfo['pseudo'] . '</i><br/><br/>'?>

                     <div class="info">
                        <div class="row">
                           <div class="two columns">
                              <?php echo '<img alt="pp" id="pp" src="/photos/'.$userinfo['profile_picture']. '">' ?>

                           </div>
                           <div class="ten columns infos" style="align-self: center">
                              <p><?php echo $userinfo['bio']; ?> </p>
                              <p> Contact : <?php echo $userinfo['email']; ?> </p>

                           </div>
                        </div>
                     </div>
                  </div>
                     <button id="button" method="get" name="f" value="follow" style="float: right">Suivre</button>
                     <br />

                     <hr class="profil_header">
                     <br />
                     <?php
                     if (isset($_SESSION['id_user']) and $userinfo['id_user'] == $_SESSION['id_user']) {
                     ?>
                        <br />
                     <?php
                     }
                     ?>
                    <div class="add_tweet">
                    <?php echo '<img alt="pp" src="/photos/'.$userinfo['profile_picture']. '">' ?>
                        <form enctype="multipart/form-data" action="" name="twitter" method="post">
                                <textarea id="tweet" placeholder="Quoi de neuf ?" name="tweet" rows="10" cols="50"></textarea>
                                <br />
                            <div class="row">
                                <div class="six columns">
                                    <input type="file" name="photo"/>
                                </div>
                                <div class="six columns" style="text-align: right">
                                    <input id="button" type="submit" name="envoyer" value="Envoyer">
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    
                    <div class="timeline">

                    <?php 

                    // include('poo_tweet.php');

                    if (isset($_SESSION['id_user'])) 
                    {
                        $following = $bdd->prepare('SELECT * FROM user INNER JOIN follow ON follow.id_followed = user.id_user WHERE follow.id_follower = ?');
                        $following->execute(array($getid));
                        while($donnees = $following->fetch())
                        {
                            echo "<div class='affprofil'>
                                    <div class='photo'>
                                        <img alt='pp' id='pp_tweet' src='/photos/". $donnees['profile_picture']. "'> 
                                    </div>
                                    <div class='infos'>
                                        <h4><b><a href='profil.php?id_user=". $donnees['id_user']. "'>". 
                                    $donnees['pseudo'] . 
                                    "</a></b></h4>
                                    <br/>
                                    <br/>
                                    </div>
                                </div>";
                        }
                    }
                    ?>

                    </div>
                </div>
               


                <div class="three columns search">
                    <div class="search_leftarea">
                        <form action="search-tag.php" method="get" style="padding-bottom: 0px;">
                            <input type="search" placeholder="Rechercher..." id="site-search" name="terme" aria-label="Search through site content">
                            <input type="submit" id="button" name="s" value="GO"> 
                        </form>
                    </div>
                </div>

         </div>
         <?php theme(); ?>
      </div>
   </body>

   <script type="text/javascript" src="auto-refresh.js"></script>
</html>

<?php } ?>
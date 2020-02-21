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
include('theme.php');

if (isset($_SESSION['id_user'])) {
   $requser = $bdd->prepare("SELECT * FROM user WHERE id_user = ?");
   $requser->execute(array($_SESSION['id_user']));
   $user = $requser->fetch();
   if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']) and $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE user SET pseudo = ? WHERE id_user = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id_user']));
      header('Location: profil.php?id_user=' . $_SESSION['id_user']);
   }
   if (isset($_POST['newmail']) and !empty($_POST['newmail']) and $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE user SET email = ? WHERE id_user = ?");
      $insertmail->execute(array($newmail, $_SESSION['id_user']));
      header('Location: profil.php?id_user=' . $_SESSION['id_user']);
   }
   if (isset($_POST['newmdp1']) and !empty($_POST['newmdp1']) and isset($_POST['newmdp2']) and !empty($_POST['newmdp2'])) {
      $mdp1 = hash('ripemd160', $_POST['newmdp1']. "vive le tweet academy");
      $mdp2 = hash('ripemd160', $_POST['newmdp2']);
      if ($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE user SET password = ? WHERE id_user = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id_user']));
         header('Location: profil.php?id_user=' . $_SESSION['id_user']);
      } else {
         $msg = "Vos deux mots de passe ne correspondent pas !";
      }
   }
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
               <button id="button" method="get" name="t" value="Tweeter">Tweeter</button>
            </div>


            <div class="eight columns center">
               <div class="timeline">
                  <div>
                     <h2>Editer mon profil</h2>
                     <div>
                        <form method="POST" action="" enctype="multipart/form-data">
                           <label>Pseudo :</label>
                           <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
                           <label>Mail :</label>
                           <input type="text" name="newmail" placeholder="email" value="<?php echo $user['email']; ?>" /><br /><br />
                           <label>Mot de passe :</label>
                           <input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
                           <label>Confirmation - mot de passe :</label>
                           <input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />
                           <input id="button" type="submit" value="Mettre à jour mon profil !" />
                        </form>
                        <h4>Changer de thème</h4>
                        <form method="POST" action="">
                           <label for="">Couleur de fond : </label>
                           <select id="backgroundch" name="theme">
                              <option value="#ffffff-0" name="00">Defaut</option>
                              <option value="#1abc9c-1" name="01">Turquoise</option>
                              <option value="#f1c40f-2" name="02">Sun Flower</option>
                              <option value="#40d47e-3" name="03">Emerald</option>
                           </select><br /><br />
                           <input id="button" name="q" type="submit" value="Mettre à jour mon thème !" />
                        </form>
                        <?php if (isset($msg)) {
                           echo $msg;
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div>

            <div class="two columns search">
               <div class="search_leftarea">
                  <form action="search.php" method="get">
                     <input placeholder="Rechercher..." id="site-search" name="terme" aria-label="Search through site content">
                     <button id="button" method="get" name="q" value="Rechercher">Go</button>
                  </form>
               </div>
            </div>


         </div>
   </body>
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
   <script type="text/javascript" src="script_test.js"></script>

</html>
<?php
} else {
   header("Location: connexion.php");
}


//------------------------Enregistrer le theme en BDD------------------------

if (isset($_POST['q']) || $_POST['q'] === "Mettre à jour mon thème !") {



   $theme_number = strpos($_POST['theme'], "-");
   $theme = substr($_POST['theme'], $theme_number + 1);

   $add_theme = $bdd->prepare('UPDATE user SET theme = ? where id_user = ?');
   $add_theme->execute(array($theme, $_SESSION['id_user']));
}
theme();
?>
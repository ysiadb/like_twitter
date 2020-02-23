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

    <?php
    try
    {
       $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

if(isset($_POST['forminscription'])) {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['email']);
    $mail2 = htmlspecialchars($_POST['email2']);
    $password = hash('ripemd160', $_POST['password'] . "vive le projet tweet_academy");
    $password2 = hash('ripemd160',$_POST['password2']. "vive le projet tweet_academy");
    if(!empty($_POST['name']) AND !empty($_POST['surname']) AND !empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['email2']) AND !empty($_POST['password']) AND !empty($_POST['password2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM user WHERE email = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($password == $password2) {
                     $insertmbr = $bdd->prepare("INSERT INTO user(name, surname, pseudo, email, password) VALUES(?, ?, ?, ?, ?)");
                     $insertmbr->execute(array($name, $surname, $pseudo, $mail, $password));
                    // var_dump($_POST['name']);
                    // var_dump($_POST['surname']);
                    // var_dump($_POST['pseudo']);
                    // var_dump($_POST['email']);
                    // var_dump($_POST['password']);
                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
</head>

<body>
    <div class="container">
    <div class="header_ban">
                <div class="row">
                    <div class="six columns">
                        <a href="index.php"><img id="logo" src="/tweetacademiee.png" alt="logo" style="width:50%"></a>
                    </div>
                    <div class="six columns right_menu">
                        <a href="connexion.php" style="color:white">Se connecter</a>

                    </div>
                </div>
        </div>
        <section class="formulaire">

            <h2 style="margin-top: 2%;">Inscription</h2>
            <form method="POST" action="">
                <table>
                    <tr>
                        <td>
                            <label for="name">Nom</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre nom" id="name" name="name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="surname">Prénom</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre prénom" id="surname" name="surname">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pseudo">Pseudo</label>
                        </td>
                        <td>
                            <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email">Email</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre email" id="email" name="email">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="email2">Confirmation Email</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre email" id="email2" name="email2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Mot de passe</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="password" name="password">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password2">Confirmation du mot de passe</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="password2" name="password2">
                        </td>
                    </tr>
                </table>
                <div style="text-align: center;">
                    <input type="submit" name="forminscription" value="Je m'inscris" />
                </div>
            </form>
            <?php
            if(isset($erreur)) 
            {
                echo '<font color="red">'.$erreur."</font>";
            }
            ?>
        </section>
        </div>
    </body>
    </html>

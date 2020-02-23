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
    session_start();

    try
    {
       $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    if(isset($_POST['formconnexion'])) {
        $emailconnect = htmlspecialchars($_POST['emailconnect']);
        $passwordconnect = hash('ripemd160', $_POST['passwordconnect']);
        if(!empty($emailconnect) AND !empty($passwordconnect)) {
           $requser = $bdd->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
           $requser->execute(array($emailconnect, $passwordconnect));
           $userexist = $requser->rowCount();
           if($userexist == 1) {
              $userinfo = $requser->fetch();
              $_SESSION['id_user'] = $userinfo['id_user'];
              $_SESSION['pseudo'] = $userinfo['pseudo'];;
              $_SESSION['email'] = $userinfo['email'];
              header("Location: profil.php?id_user=".$_SESSION['id_user']);
           } else {
              $erreur = "Mauvais mail ou mot de passe !";
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
                        <a href="inscription.php" style="color:white">S'inscrire</a>

                    </div>
                </div>
        </div>



        <section class="formulaire">

            <h2 style="margin-top: 2%;">Connexion</h2>
            <form method="POST" action="">
                <table>
                    <tr>
                        <td>
                            <label for="email">Email</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Votre email" id="emailconnect" name="emailconnect">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Mot de passe</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Votre mot de passe" id="passwordconnect" name="passwordconnect">
                        </td>
                    </tr>
                </table>
                <div style="text-align: center;">
                    <input type="submit" name="formconnexion" value="Je me connecte" />
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

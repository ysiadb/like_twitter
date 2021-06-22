<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <!-- BASICS 
    ______________________________-->

    <meta charset="UTF-8">
    <title>Tweet_Acadéémie</title>

    <!-- CSS 
    ______________________________-->

    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <link rel="stylesheet" href="https://use.typekit.net/gsh6pdg.css">
    <link rel="stylesheet" type="text/css" href="./css/normalize.css">
    <link rel="stylesheet" type="text/css" href="./css/skeleton.css">

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
    include('theme.php');
    if (isset($_SESSION['id_user'])) 
    {
        $requser = $bdd->prepare("SELECT * FROM user WHERE id_user = ?");
        $requser->execute(array($_SESSION['id_user']));
        $user = $requser->fetch();
    ?>
</head>

<body>
    <div class="container">
        <div class="header_ban">
            <div class="row">
                <div class="six columns">
                    <a href="index.php"><img id="logo" src="./tweetacademiee.png" alt="logo" style="width:50%"></a>
                </div>
                <div class="six columns right_menu">
                    <a href="deconnexion.php" style="color:white">Se déconnecter</a>

                </div>
            </div>
        </div>

            <div class="row main">

                <div class="one column menu">
                    <div class="left_menu">
                        <a href="index.php"><img src="./MISC/home.png" alt="Accueil"> Accueil</a>
                        <a href=""><img src="./MISC/hashtag.png" alt="#Explorer"> Explorer</a>
                        <a href=""><img src="./MISC/message.png" alt="Message"> Message</a>
                        <a href="profil.php?id_user=<?= $_SESSION['id_user'] ?>"> <img src="./MISC/profil.png" alt="Profil">Profil</a>
                    </div>
                    <a href="#tweeeet"><button id="button" method="get" name="t" value="Tweeter">Tweeter</button></a>
                </div>
               


                <div class="eight columns center">
                    <div class="add_tweet" id="tweeeet">
                        <form enctype="multipart/form-data" action="" name="twitter" method="post">
                        <?php echo '<img alt="pp" id="pp_tweet" src="./photos/'.$user['profile_picture']. '">' ?>
                                <textarea id="tweet" placeholder="Quoi de neuf ?" name="tweet" rows="10" cols="50"></textarea>
                                <div id="compteur" style="text-align:right">0</div>
                                <br />
                            <div class="row addpic">
                                <div class="six columns">
                                    <input type="file" name="photo"/>
                                </div>
                                <div class="six columns" style="text-align: right">
                                    <input id="button" type="submit" name="envoyer" value="Tweeter">
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <div class="timeline">
                    <?php
                        include("poo_tweet.php");
                    ?>

                    </div>
                </div>


                <div class="three columns search">
                    <div class="search_leftarea">
                        <form action="search-tag.php" method="get" style="padding-bottom: 0px;">
                            <input type="search" placeholder="Rechercher..." id="site-search" name="terme" aria-label="Search through site content">
                            <input type="submit" id="buttong" name="s" value="GO"> 
                        </form>
                    </div>
                </div>

            </div>

    <?php
     theme();
     ?>
    
    </body>
    <!-- <script type="text/javascript">
   setTimeout(function() {
  location.reload();
}, 30000);
    </script> -->
<script type="text/javascript">
    
            function maxlength_textarea(id, crid, max)
            {
                var txtarea = document.getElementById(id);
                document.getElementById(crid).innerHTML=max-txtarea.value.length;
                txtarea.onkeypress=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
                txtarea.onblur=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
                txtarea.onkeyup=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
                txtarea.onkeydown=function(){eval('v_maxlength("'+id+'","'+crid+'",'+max+');')};
            }
            function v_maxlength(id, crid, max)
            {
                var txtarea = document.getElementById(id);
                var crreste = document.getElementById(crid);
                var len = txtarea.value.length;
                if(len>max)
                {
                    txtarea.value=txtarea.value.substr(0,max);
                }
                len = txtarea.value.length;
                crreste.innerHTML=max-len;
            }
        </script>
        </head>
    <script type="text/javascript">

            maxlength_textarea('tweet','compteur',140);
    </script>
</html>

<?php

} else {
   header("Location: connexion.php");
}
?>
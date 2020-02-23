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
    include('theme.php');

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    if (isset($_GET["s"]) == "search") {
        $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les intrusions http
        $terme = $_GET["terme"];
        $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
        $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

        if (isset($terme)) {
            $terme = strtolower($terme);
            $select_terme = $bdd->prepare('SELECT * FROM tweet INNER JOIN user ON tweet.id_autor = user.id_user WHERE content_tweet LIKE ?');
            $select_terme->execute(array("%" . $terme . "%"));
        }

        if (isset($terme))
        {
            $terme = strtolower($terme);
            $select_pseudo = $bdd->prepare('SELECT * FROM user WHERE pseudo LIKE ?');
            $select_pseudo->execute(array("%".$terme."%"));
        }

    }
    if (isset($_SESSION['id_user'])) {
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
                    <a href="index.php"><img id="logo" src="/tweetacademiee.png" alt="logo" style="width:50%"></a>
                </div>
                <div class="six columns right_menu">
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
                    <?php
                    echo "<div><h2>" . "Votre recherche \"" . $terme . "\" a trouvé les résultats suivants : " . "</div></h2>" . "<br/>" . "<br/>" ?>

                    <?php
                   
                    while ($terme_trouve = $select_terme->fetch()) 
                    {

                        echo "<h3>Tweets : </h3>";

                        if ($terme_trouve['url_image'] != '') 
                        {
                            echo
                                "<div class='afftweet'> 
                            <div class='affprofil'>
                                <div class='photo'>
                                    <img alt='pp' id='pp_tweet' src='/photos/". $terme_trouve['profile_picture']. "'>
                                </div>
                                <div class='infos'>
                                    <b style='font-size: 20px; color:#33ccff'>" . $terme_trouve['pseudo'] . "</b>
                                    <i style='font-size: 12px; color: grey;'>" . "• " . $terme_trouve['tweet_date'] . "</i>
                                </div>
                            </div>
                            <div class='message'><p id='content_tweet'>" . $terme_trouve['content_tweet'] . "</p><br/><br/>
                                <div class='tweetimage'>" . "<img src=/photos/" . $terme_trouve['url_image'] . "></div>
                            </div><br/>
                        </div><br/>";
                        } 
                        else 
                        {
                            echo
                                "<div class='afftweet'> 
                        <div class='affprofil'>
                                <div class='photo'>
                                    <img alt='pp' id='pp_tweet' src='/photos/". $terme_trouve['profile_picture']. "'>
                                </div>
                                <div class='infos'>
                                    <b style='font-size: 20px; color:#33ccff'>" . $terme_trouve['pseudo'] . "</b>
                                    <i style='font-size: 12px; color: grey;'>" . "• " . $terme_trouve['tweet_date'] . "</i>
                                </div>
                        </div>
                        <div class='message'><p id='content_tweet'>" . $terme_trouve['content_tweet'] . "</p>
                        </div>
                    </div><br/>";
                        }
                    }

                    $select_terme->closeCursor();

                    while ($terme_trouve = $select_pseudo->fetch()) 
                    {
                            echo "<hr><h3>Profils utilisateurs : </h3>";
                            echo "<div class='affprofil'>" .
                                    "<div class='photo'>" . 
                                        "<img alt='pp' id='pp_tweet' src='/photos/". $terme_trouve['profile_picture']. "'> 
                                    </div>".
                                    "<div class='infos'>" .
                                        "<h4><b><a href=\"profil.php?id_user=". $terme_trouve['id_user']. "\">". 
                                    $terme_trouve['pseudo'] . 
                                    "</a></b></h4>". "<br/>" . 
                                    "<br/>" . 
                                "</div></div>";

                    }

                    $select_pseudo->closeCursor();

                    
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
    </div>
        
    </div>

    <?php
        theme();
    ?>

</body>
<script type="text/javascript" src="auto-refresh.js"></script>

</html>

<?php

    } else {
        header("Location: connexion.php");
    }

?>
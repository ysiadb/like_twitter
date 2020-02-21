<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
 } 
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}


if (isset($_GET["s"]) == "search") {
    $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les intrusions html
    $terme = $_GET["terme"];
    $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
    $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

    if (isset($terme)) {
        $terme = strtolower($terme);
        $select_terme = $bdd->prepare("SELECT * FROM tweet WHERE content_tweet LIKE '%?%'");
        $select_terme->execute(array("%" . $terme . "%"));
    }    
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>My tweet</title>
</head>

<body>
    <?php
	 echo "<div><h2>" ."Votre recherche \"" . $terme . "\" a trouvé les résultats suivants : " . "</div></h2>" . "<br/>" . "<br/>" ?>

    <div class="afftweet">
    
    <?php
    while($terme_trouve = $select_terme->fetch())
    {
        echo
     "<div class='afftweet'> 
        <div class='affprofil'>".$terme_trouve['pseudo']. "</div><br/>
        <div class='message'>".$terme_trouve['content_tweet']."<div class='tweetimage'>"."<img src=/photos/".$afftweet[$i]['url_image']."></div></div><br/>
        <div class='horaire'>".$terme_trouve['tweet_date']."</div>
    </div><br/><br/>";
    }
    
    $select_terme->closeCursor();
     ?>

    </div>

</body>
</html>

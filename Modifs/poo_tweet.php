<?php

try {
    $bdd = new PDO('mysql:host=localhost;dbname=common-database;charset=utf8', 'root', 'HelloRoot');
 } 
catch (Exception $e) 
{
    die('Erreur : ' . $e->getMessage());
}

if (isset($_POST["envoyer"]))
{
    $tweet = $_POST["tweet"];
    $photo = $_FILES["photo"];
    $dossier ='/home/wac/daisyB-repo/tweet_academie/Daisy/photos/';
    $tmp_name = $_FILES["photo"]["tmp_name"];
    $name = $_FILES["photo"]["name"];

    if ($photo != NULL)
    {
        $req = $bdd->prepare("INSERT INTO tweet(id_autor, tweet_date, content_tweet, url_image) 
                            VALUES ($_SESSION[id_user], NOW(), '$tweet', '$name')");
        $req->execute();

        move_uploaded_file($tmp_name, "$dossier/$name");
    }
    else
    {
    $req = $bdd->prepare("INSERT INTO tweet(id_autor, tweet_date, content_tweet) 
                        VALUES ($_SESSION[id_user], NOW(), '$tweet')");
    $req->execute();
    }
}

$reqtweet = $bdd->prepare("SELECT * FROM tweet INNER JOIN user ON tweet.id_autor = user.id_user ORDER BY id_tweet DESC");
$reqtweet->execute();
$nbr = $reqtweet->rowCount();

$afftweet = $reqtweet->fetchAll();

for($i = 0; $i < $nbr; $i++)
{
    if ($afftweet[$i]['url_image'] != '')
    {
        echo 
    "<div class='afftweet'> 
        <div class='affprofil'>".$afftweet[$i]['pseudo']. "</div><br/>
        <div class='message'>".$afftweet[$i]['content_tweet']."<div class='tweetimage'>"."<img src=/photos/".$afftweet[$i]['url_image']."></div></div><br/>
        <div class='horaire'>".$afftweet[$i]['tweet_date']."</div>
    </div><br/><br/>";
    }

    else
    {
    echo 
        "<div class='afftweet'> 
            <div class='affprofil'>".$afftweet[$i]['pseudo']. "</div><br/>
            <div class='message'>".$afftweet[$i]['content_tweet']."></div><br/>
            <div class='horaire'>".$afftweet[$i]['tweet_date']."</div>
        </div><br/><br/>";
    }
}
?>
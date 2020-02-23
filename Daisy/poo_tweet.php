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


    // MENTIONS

//     $tweet = "Hello @titi !";
//     var_dump($tweet);

//     function mentionnerUtilisateur($matches) { 
//         global $bdd; 
//         var_dump($matches); 
//         $req = $bdd->prepare('SELECT * FROM user WHERE pseudo = ?'); 
//         $req->execute(array($matches[1])); 
     
//         if($req->rowCount() == 1) { 
//             $idUtilisateur = $req->fetch()['id_user']; 
//             return '<a href="profil.php?id_user='.$idUtilisateur.'">'.$matches[0].'</a>'; 
//         } 
//         return $matches[0]; 
//     } 
//     $tweet = preg_replace_callback('#@([A-Za-z0-9]+)#', 'mentionnerUtilisateur', ""); 
     
//     echo $tweet; 
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
        <div class='affprofil'>
            <div class='photo'>
                <img alt='pp' id='pp_tweet' src='/photos/". $afftweet[$i]['profile_picture']. "'>
            </div>
            <div class='infos'>
            <a href='profil.php?id_user=". $afftweet[$i]['id_user']."'><b style='font-size: 20px; color:#33ccff'>".$afftweet[$i]['pseudo']."</b></a>
            <i style='font-size: 12px; color: grey;'>"."• ".$afftweet[$i]['tweet_date']."</i></div>
        </div>
        <div class='message'><p id='content_tweet'>".$afftweet[$i]['content_tweet']."</p><br/><br/>
            <div class='tweetimage'>"."<img src=/photos/".$afftweet[$i]['url_image']."></div>
        </div><br/>
    </div><br/>";
    }

    else
    {
    echo 
    "<div class='afftweet'> 
    <div class='affprofil'>
        <div class='photo'>
            <img alt='pp' id='pp_tweet' src='/photos/". $afftweet[$i]['profile_picture']. "'>
        </div>
        <div class='infos'>
        <a href='profil.php?id_user=". $afftweet[$i]['id_user']."'><b style='font-size: 20px; color:#33ccff'>".$afftweet[$i]['pseudo']."</b></a>
        <i style='font-size: 12px; color: grey;'>"."• ".$afftweet[$i]['tweet_date']."</i></div>
    </div><br/>
    <div class='message'><p id='content_tweet'>".$afftweet[$i]['content_tweet']."</p>
    </div>
</div><br/>";
    }
}

?>
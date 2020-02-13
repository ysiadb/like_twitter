<?php
include("bdd.php");

if (isset($_POST["envoyer"]))
{
    $tweet = $_POST["tweet"];

    $req = $PDO->prepare("INSERT INTO msg(id_membre, tweet_date, content_tweet) 
                        VALUES ($_SESSION[id_membre], NOW(), '$tweet')");
    $req->execute();
}

$reqtweet = $PDO->prepare("SELECT * FROM msg INNER JOIN membre ON msg.id_membre = membre.id_membre ORDER BY id_msg DESC");
$reqtweet->execute();
$nbr = $reqtweet->rowCount();

$afftweet = $reqtweet->fetchAll();

for($i = 0; $i < $nbr; $i++)
{
echo 
    "<div class='afftweet'> 
        <div class='affprofil'>".$afftweet[$i]['pseudo']. "</div><br/>
        <div class='message'>".$afftweet[$i]['content_tweet']."</div><br/> 
        <div class='horaire'>
        ".$afftweet[$i]['tweet_date']."
        </div>
    </div><br/><br/>";
}

?>
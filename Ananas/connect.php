<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=tweet_aca_test', 'root', 'root');

	echo "successed";
     }
catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

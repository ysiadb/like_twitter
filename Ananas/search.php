<?php

include("connect.php");

if (isset($_GET["s"]) == "Rechercher") {
    $_GET["terme"] = htmlspecialchars($_GET["terme"]); //pour sécuriser le formulaire contre les intrusions html
    $terme = $_GET["terme"];
    $terme = trim($terme); //pour supprimer les espaces dans la requête de l'internaute
    $terme = strip_tags($terme); //pour supprimer les balises html dans la requête

    if (isset($terme)) {
        $terme = strtolower($terme);
        $select_terme = $bdd->prepare("SELECT * FROM tweet WHERE content_tweet LIKE ?");
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
	<form action="search.php" method="get">
			<input type="search" name="terme">
			<input type="submit" name="s" value="GO">
	</form>

</body>
</html>


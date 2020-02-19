<?php
include("bdd.php");

if(isset($_POST["search"]))
{
    $search = $_POST["search"];
    
    $reqS = $PDO->prepare("SELECT * FROM membre WHERE pseudo, prenom LIKE '%$search%'");
    $reqS->execute();
    
}
?>
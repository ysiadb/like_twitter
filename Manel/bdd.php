 <?php
 
        try
        {
            $PDO = new PDO ('mysql:host=localhost;dbname=tweet_academie','admin','root');
        }

        catch (Exception $e)
        {
            die('Erreur:' .$e->getMessage());
        }
?>
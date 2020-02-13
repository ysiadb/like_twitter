 <?php
 
        try
        {
            $PDO = new PDO ('mysql:host=localhost;dbname=Test','admin','root');
        }

        catch (Exception $e)
        {
            die('Erreur:' .$e->getMessage());
        }

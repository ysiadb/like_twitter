 <?php
include("bdd.php");
session_start();

        if(isset($_POST["connexion"]))
        {
            $connect = htmlspecialchars($_POST['prenom']);
            $pseudo = htmlspecialchars($_POST['pseudo']);
            
            if(!empty($connect) AND !empty($pseudo))
            {
                $connexion = $PDO->prepare("SELECT * FROM membre WHERE prenom='$connect' AND pseudo='$pseudo'");
                $connexion->execute();
                $membre_exist = $connexion->rowCount();
            
                if($membre_exist == 1)
                {
                    $membre_exist = $connexion->fetch();
                    $_SESSION['id_membre'] = $membre_exist['id_membre'];
                    $_SESSION['prenom'] = $membre_exist['prenom'];
                    $_SESSION['pseudo'] = $membre_exist['pseudo'];
                    header("Location: profil.php");
                }
                else
                {
                    echo "Mauvais identifiant ou mot de passe !";
                }
            }
            else 
            {
                echo "Tous les champs doivent être remplis";
            }
        }
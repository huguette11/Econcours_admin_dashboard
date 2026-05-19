<?php
    //PAGE DE TRAITEMENT D'UNE CONNEXION 

    session_start();

    $_SESSION['password']=0;

    if(isset($_POST['username']) && isset($_POST['password']))
    {   
        // connexion à la base de données
        include('connect_db.php');
        
        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS
        $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'])); 
        $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password']));
    

        if($username !== "" && $password !== "")
        {
            $requete = "SELECT count(*),password FROM utilisateur where 
                    (username = '".$username."'  )  ";
            $exec_requete = mysqli_query($db,$requete);
            $reponse      = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];
            if($count==1 && password_verify($password, $reponse['password'])) // nom d'utilisateur et mot de passe correctes
            {

                include('connect_db_pdo.php');// connexion pdo à la base de données

                $requete = $bdd->prepare('SELECT id_utilisateur,username,type_compte FROM utilisateur  WHERE username=?  '); //Récuperation des infos sur l'utilisateur souhaitant connectant
                $requete->execute(array($_POST['username']));
                while ($donnee=$requete->fetch()) 
                {  
                    //Initialisation des variables de session

                    $_SESSION['id']=$donnee['id_utilisateur'];
                    $_SESSION['username']=$donnee['username']; 
                    $_SESSION['type_compte']=$donnee['type_compte']; 
                
                }
            
                $nom_action = "Connexion";
                $nom_table="utilisateur";
                $adresse_ip = $_SERVER['REMOTE_ADDR'];

                //Historique des action
                $requete1 = $bdd->prepare('INSERT INTO historique_action(id_utilisateur,adresse_ip,nom_table,nom_action) VALUES(?,?,?,?)');
                $requete1->execute(array($_SESSION['id'],$adresse_ip,$nom_table,$nom_action));
            
                //Initialisation des variables de session utilisées pour les sweats alerts
            
            
                $_SESSION['supr']=0;
                $_SESSION['mod']=0;
                $_SESSION['ajout']=0;

                // Fermer la connexion
                mysqli_close($db);    
                $bdd=null;
                header('Location:../../pages/index.php'); 
            }
            else
            {
                mysqli_close($db);   // Fermer la connexion   
                $bdd=null;
                $_SESSION['err']=1;

                header('Location:../../login.php'); // utilisateur ou mot de passe incorrect
            }
        }
        else
        {
            mysqli_close($db);    // fermer la connexion
            $_SESSION['err']=2;

            header('Location:../../login.php'); // utilisateur ou mot de passe vide
        }
    }
    else
    {
        header('Location:../../login.php');
    }

?>
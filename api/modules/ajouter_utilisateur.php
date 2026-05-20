<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        if( isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['adresse']) && isset($_POST['username']) && isset($_POST['type_compte']) && isset($_POST['password']) ) 
        {   
            // connexion à la base de données
            include('connect_db.php');
            
            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $nom = mysqli_real_escape_string($db,htmlspecialchars($_POST['nom'],ENT_QUOTES)); 
            $prenom = mysqli_real_escape_string($db,htmlspecialchars($_POST['prenom'],ENT_QUOTES)); 
            $date_naissance = mysqli_real_escape_string($db,htmlspecialchars($_POST['date_naissance'],ENT_QUOTES)); 
            $telephone = mysqli_real_escape_string($db,htmlspecialchars($_POST['telephone'],ENT_QUOTES)); 
            $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email'],ENT_QUOTES));  
            $adresse = mysqli_real_escape_string($db,htmlspecialchars($_POST['adresse'],ENT_QUOTES));       
            $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['username'],ENT_QUOTES)); 
            $type_compte = mysqli_real_escape_string($db,htmlspecialchars($_POST['type_compte'],ENT_QUOTES)); 
            $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['password'],ENT_QUOTES)); 
            $hash = password_hash($password, PASSWORD_DEFAULT);
    
            $nom  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $nom);
            $prenom  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $prenom);
            $date_naissance  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $date_naissance);
            $telephone  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $telephone);
            $email  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $email);
            $adresse  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $adresse);    
            $username  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $username);

            $requete = "SELECT count(*) FROM utilisateur where (username = '".$username."' )  ";
            $exec_requete = mysqli_query($db,$requete);
            $reponse      = mysqli_fetch_array($exec_requete);
            $count = $reponse['count(*)'];

            if($count==0)
            {
                // connexion à la base de données
                include('connect_db_pdo.php');

                $requete = $bdd->prepare('INSERT INTO utilisateur(nom,prenom,date_naissance,telephone,email,adresse,username,password,type_compte) VALUES(?,?,?,?,?,?,?,?,?)');
                $requete->execute(array($nom,$prenom,$date_naissance,$telephone,$email,$adresse,$username,$hash,$type_compte));

                //Historique des action
                $requete = $bdd->prepare('SELECT id_utilisateur FROM utilisateur ORDER BY id_utilisateur DESC LIMIT 1');
                $requete->execute(array());
                
                while ($donnee=$requete->fetch()) {
                    $id_utilisateur=$donnee['id_utilisateur'];
                }

                $nom_table="utilisateur";
                $nom_action="Ajout utilisateur";
                $adresse_ip = $_SERVER['REMOTE_ADDR'];

                $requete = $bdd->prepare('INSERT INTO historique_action(id_utilisateur,adresse_ip,id_user,nom_table,nom_action) VALUES(?,?,?,?,?)');
                $requete->execute(array($_SESSION['id'],$adresse_ip,$id_utilisateur,$nom_table,$nom_action));
                //Historique des action

                // Fermer la connexion
                mysqli_close($db);    
                $bdd=null;
                
                $_SESSION['ajout']=1;
                
                header('Location:../../pages/utilisateur.php');
            }
            else
            {   
                // Fermer la connexion
                mysqli_close($db);    
                $_SESSION['imp']=1;
                
                header('Location:../../pages/utilisateur.php');   
            }

        }
        else
        {
            header('Location:../../pages/utilisateur.php');
        }   
    }
?>
  

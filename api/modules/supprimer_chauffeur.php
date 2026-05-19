<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur" )) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        if(isset($_GET['id_chauffeur'])) 
        {
            //Connexion_bd
            include('connect_db.php');
            include('connect_db_pdo.php');  
                
            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS 

            $id = mysqli_real_escape_string($db,htmlspecialchars($_GET['id_chauffeur']));

            $requete = $bdd->prepare('UPDATE chauffeur SET suppression = ? WHERE id_chauffeur=?');
            $requete->execute(array("Oui",$id));
            
            //Historique des action
            $nom_table="chauffeur";
            $nom_action="Suppression chauffeur";
            $adresse_ip = $_SERVER['REMOTE_ADDR'];

            $requete2 = $bdd->prepare('INSERT INTO historique_action(id_chauffeur,adresse_ip,id_user,nom_table,nom_action) VALUES(?,?,?,?,?)');
            $requete2->execute(array($id,$adresse_ip,$_SESSION['id'],$nom_table,$nom_action));


            // Fermer la connexion bd
            mysqli_close($db);
            $bdd=null;

            $_SESSION['supr']=1;

            header('Location:../../pages/chauffeur.php');
        }else{
            header('Location:../../pages/chauffeur.php');
        }
    }
?>
  

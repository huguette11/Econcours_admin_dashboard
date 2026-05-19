<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        if( isset($_POST['id_gare']) && isset($_POST['nom_chauffeur']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['permis'])  ) 
        {   
            // connexion à la base de données
            include('connect_db.php');
            
            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $id_gare = mysqli_real_escape_string($db,htmlspecialchars($_POST['id_gare'],ENT_QUOTES)); 
            $nom_chauffeur = mysqli_real_escape_string($db,htmlspecialchars($_POST['nom_chauffeur'],ENT_QUOTES)); 
            $prenom = mysqli_real_escape_string($db,htmlspecialchars($_POST['prenom'],ENT_QUOTES)); 
            $telephone = mysqli_real_escape_string($db,htmlspecialchars($_POST['telephone'],ENT_QUOTES)); 
            $permis = mysqli_real_escape_string($db,htmlspecialchars($_POST['permis'],ENT_QUOTES));  


            $nom_chauffeur = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $nom_chauffeur);
            $prenom  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $prenom);
            $telephone  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $telephone);
            $permis  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $permis);
           
            
                // connexion à la base de données
        include('connect_db_pdo.php');

        $requete = $bdd->prepare('INSERT INTO chauffeur(id_gare, nom_chauffeur, prenom, telephone, permis) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_gare, $nom_chauffeur, $prenom, $telephone, $permis));

        //Historique des actions
        $requete = $bdd->prepare('SELECT id_chauffeur FROM chauffeur ORDER BY id_chauffeur DESC LIMIT 1');
        $requete->execute(array());

        while ($donnee = $requete->fetch()) {
            $id_chauffeur = $donnee['id_chauffeur'];
        }
        // $id_user = $_SESSION['id'];
        $nom_table = "chauffeur";
        $nom_action = "Ajout chauffeur";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        $requete = $bdd->prepare('INSERT INTO historique_action(id_chauffeur, adresse_ip, id_user, nom_table, nom_action) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_chauffeur, $adresse_ip, $_SESSION['id'], $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['ajout'] = 1;

        header('Location:../../pages/chauffeur.php');
    } else {
        header('Location:../../pages/chauffeur.php');
    }
}

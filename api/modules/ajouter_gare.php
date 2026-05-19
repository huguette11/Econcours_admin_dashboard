<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        if( isset($_POST['nom']) && isset($_POST['adresse']) && isset($_POST['telephone']) && isset($_POST['email'])  ) 
        {   
            // connexion à la base de données
            include('connect_db.php');
            
            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $nom = mysqli_real_escape_string($db,htmlspecialchars($_POST['nom'],ENT_QUOTES)); 
            $adresse = mysqli_real_escape_string($db,htmlspecialchars($_POST['adresse'],ENT_QUOTES)); 
            $telephone = mysqli_real_escape_string($db,htmlspecialchars($_POST['telephone'],ENT_QUOTES)); 
            $email = mysqli_real_escape_string($db,htmlspecialchars($_POST['email'],ENT_QUOTES));  
           
    
            $nom  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $nom);
            $adresse  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $adresse);
            $telephone  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $telephone);
            $email  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $email);

            // connexion à la base de données
        include('connect_db_pdo.php');

        $requete = $bdd->prepare('INSERT INTO gare(nom,adresse,telephone,email) VALUES(?,?,?,?)');
        $requete->execute(array($nom, $adresse, $telephone, $email));

        //Historique des actions
        $requete = $bdd->prepare('SELECT id_gare FROM gare ORDER BY id_gare DESC LIMIT 1');
        $requete->execute(array());

        while ($donnee = $requete->fetch()) {
            $id_gare = $donnee['id_gare'];
        }
        // $id_user = $_SESSION['id'];
        $nom_table = "gare";
        $nom_action = "Ajout gare";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        $requete = $bdd->prepare('INSERT INTO historique_action(id_gare, adresse_ip, id_user, nom_table, nom_action) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_gare, $adresse_ip, $_SESSION['id'], $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['ajout'] = 1;

        header('Location:../../pages/gare.php');
    } else {
        header('Location:../../pages/gare.php');
    }
}

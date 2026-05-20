<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        if( isset($_POST['id_gare']) && isset($_POST['immatriculation']) && isset($_POST['capacite']) && isset($_POST['modele']) && isset($_POST['etat'])  ) 
        {   
            // connexion à la base de données
            include('connect_db.php');
            
            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $id_gare = mysqli_real_escape_string($db,htmlspecialchars($_POST['id_gare'],ENT_QUOTES)); 
            $immatriculation = mysqli_real_escape_string($db,htmlspecialchars($_POST['immatriculation'],ENT_QUOTES)); 
            $capacite = mysqli_real_escape_string($db,htmlspecialchars($_POST['capacite'],ENT_QUOTES)); 
            $modele = mysqli_real_escape_string($db,htmlspecialchars($_POST['modele'],ENT_QUOTES)); 
            $etat = mysqli_real_escape_string($db,htmlspecialchars($_POST['etat'],ENT_QUOTES));  


            $immatriculation = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $immatriculation);
            $capacite  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $capacite);
            $modele  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $modele);
            $etat  = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $etat);


            // connexion à la base de données
        include('connect_db_pdo.php');

        $requete = $bdd->prepare('INSERT INTO car(id_gare, immatriculation, capacite, modele, etat) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_gare, $immatriculation, $capacite, $modele, $etat));

        //Historique des actions
        $requete = $bdd->prepare('SELECT id_car FROM car ORDER BY id_car DESC LIMIT 1');
        $requete->execute(array());

        while ($donnee = $requete->fetch()) {
            $id_car = $donnee['id_car'];
        }
        // $id_user = $_SESSION['id'];
        $nom_table = "car";
        $nom_action = "Ajout car";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        $requete = $bdd->prepare('INSERT INTO historique_action(id_car, adresse_ip, id_user, nom_table, nom_action) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_car, $adresse_ip, $_SESSION['id'], $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['ajout'] = 1;

        header('Location:../../pages/car.php');
    } else {
        header('Location:../../pages/car.php');
    }
}

<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur" )) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        //PAGE DE TRAITEMENT D'UNE DECONNEXION
        session_start();
        //connexion à la base de données
        include('../api/modules/connect_db_pdo.php');

        $nom_action = "Déconnexion";
        $nom_table="utilisateur";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        //Historique des action
        $requete1 = $bdd->prepare('INSERT INTO historique_action(id_utilisateur,adresse_ip,nom_table,nom_action) VALUES(?,?,?,?)');
        $requete1->execute(array($_SESSION['id'],$adresse_ip,$nom_table,$nom_action));
        

        session_unset();
        session_destroy();
        
        header('Location: ../login.php');
        exit;
    }
?>
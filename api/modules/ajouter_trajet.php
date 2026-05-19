<?php
    session_start();
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        if( isset($_POST['id_gare']) && isset($_POST['ville_depart']) && isset($_POST['ville_arrivee']) && isset($_POST['distance']) && isset($_POST['heure_depart']) && isset($_POST['heure_arrivee']) && isset($_POST['prix'])  ) 
        {   
            // connexion à la base de données
            include('connect_db.php');
            
            // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
            // pour éliminer toute attaque de type injection SQL et XSS
            $id_gare = mysqli_real_escape_string($db,htmlspecialchars($_POST['id_gare'],ENT_QUOTES)); 
            $ville_depart = mysqli_real_escape_string($db,htmlspecialchars($_POST['ville_depart'],ENT_QUOTES)); 
            $ville_arrivee = mysqli_real_escape_string($db,htmlspecialchars($_POST['ville_arrivee'],ENT_QUOTES)); 
            $distance = mysqli_real_escape_string($db,htmlspecialchars($_POST['distance'],ENT_QUOTES)); 
            $heure_depart = mysqli_real_escape_string($db,htmlspecialchars($_POST['heure_depart'],ENT_QUOTES)); 
            $heure_arrivee = mysqli_real_escape_string($db,htmlspecialchars($_POST['heure_arrivee'],ENT_QUOTES)); 
            $prix = mysqli_real_escape_string($db,htmlspecialchars($_POST['prix'],ENT_QUOTES)); 


            $ville_depart = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $ville_depart);
            $ville_arrivee = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $ville_arrivee);
            $distance = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $distance);
            $heure_depart = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $heure_depart);
            $heure_arrivee = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $heure_arrivee);
            $prix = str_ireplace(array("\r\n",'\r\n',"\r","\n",'\r','\n'),'<br>', $prix);

            // connexion à la base de données
        include('connect_db_pdo.php');

        $requete = $bdd->prepare('INSERT INTO trajet(id_gare, ville_depart, ville_arrivee, distance, heure_depart, heure_arrivee, prix) VALUES(?,?,?,?,?,?,?)');
        $requete->execute(array($id_gare, $ville_depart, $ville_arrivee, $distance, $heure_depart, $heure_arrivee, $prix));

        //Historique des actions
        $requete = $bdd->prepare('SELECT id_trajet FROM trajet ORDER BY id_trajet DESC LIMIT 1');
        $requete->execute(array());

        while ($donnee = $requete->fetch()) {
            $id_trajet = $donnee['id_trajet'];
        }
        // $id_user = $_SESSION['id'];
        $nom_table = "trajet";
        $nom_action = "Ajout trajet";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        $requete = $bdd->prepare('INSERT INTO historique_action(id_trajet, adresse_ip, id_user, nom_table, nom_action) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_trajet, $adresse_ip, $_SESSION['id'], $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['ajout'] = 1;

        header('Location:../../pages/trajet.php');
    } else {
        header('Location:../../pages/trajet.php');
    }
}

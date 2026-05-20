<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (isset($_POST['id_client']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['num_cnib']) && isset($_POST['telephone']) && isset($_POST['email']) ) {
        // connexion à la base de données
        include('connect_db.php');

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS 

        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_client']));
        $nom = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom'], ENT_QUOTES));
        $num_cnib = mysqli_real_escape_string($db, htmlspecialchars($_POST['num_cnib'], ENT_QUOTES));
        $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom'], ENT_QUOTES));
        $telephone = mysqli_real_escape_string($db, htmlspecialchars($_POST['telephone'], ENT_QUOTES));
        $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email'], ENT_QUOTES));
        

        $nom  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $nom);
        $prenom  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $prenom);
        $num_cnib  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $num_cnib);
        $telephone  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $telephone);
        $email  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $email);
    
        include('connect_db_pdo.php');


        // Récupérer les anciennes valeurs
        $requeteOld = $bdd->prepare("SELECT * FROM client WHERE id_client = ?");
        $requeteOld->execute(array($id));
        $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

        $requete = $bdd->prepare('UPDATE client SET nom = ?, prenom = ?, num_cnib = ?, telephone = ?, email = ? WHERE id_client = ?');
        $requete->execute(array($nom, $prenom, $num_cnib, $telephone, $email, $id));

        $id_user = $_SESSION['id'];
        $nom_table = "client";
        $nom_action = "Modification client";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        // Valeurs pour historique
        $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
        $nouvelle_valeur = json_encode([
            'id_client' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'num_cnib' => $num_cnib,
            'telephone' => $telephone,
            'email' => $email,
        ], JSON_UNESCAPED_UNICODE);

        //Historique des action
        $requete2 = $bdd->prepare('INSERT INTO historique_action(id_client,adresse_ip,id_user,ancienne_valeur,nouvelle_valeur,nom_table,nom_action) VALUES(?,?,?,?,?,?,?)');
        $requete2->execute(array( $id, $adresse_ip,$_SESSION['id'], $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['mod'] = 1;

        header('Location:../../pages/client.php');
    } else {
        header('Location:../../pages/client.php');
    }

    // fermer la connexion
}

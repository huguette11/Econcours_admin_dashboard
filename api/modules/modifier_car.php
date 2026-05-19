<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (isset($_POST['id_car']) && isset($_POST['id_gare'])  && isset($_POST['immatriculation']) && isset($_POST['capacite']) && isset($_POST['modele']) && isset($_POST['etat']) ) {
        // connexion à la base de données
        include('connect_db.php');

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS 

        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_car']));
        $id_gare = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_gare'], ENT_QUOTES));
        $immatriculation = mysqli_real_escape_string($db, htmlspecialchars($_POST['immatriculation'], ENT_QUOTES));
        $capacite = mysqli_real_escape_string($db, htmlspecialchars($_POST['capacite'], ENT_QUOTES));
        $modele = mysqli_real_escape_string($db, htmlspecialchars($_POST['modele'], ENT_QUOTES));
        $etat = mysqli_real_escape_string($db, htmlspecialchars($_POST['etat'], ENT_QUOTES));


        $immatriculation = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $immatriculation);
        $capacite  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $capacite);
        $modele  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $modele);
        $etat  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $etat);

        include('connect_db_pdo.php');


        // Récupérer les anciennes valeurs
        $requeteOld = $bdd->prepare("SELECT * FROM car WHERE id_car = ?");
        $requeteOld->execute(array($id));
        $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

        $requete = $bdd->prepare('UPDATE car SET id_gare = ?, immatriculation = ?, capacite = ?, modele = ?, etat = ? WHERE id_car = ?');
        $requete->execute(array($id_gare, $immatriculation, $capacite, $modele, $etat, $id));

        $id_user = $_SESSION['id'];
        $nom_table = "car";
        $nom_action = "Modification car";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        // Valeurs pour historique
        $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
        $nouvelle_valeur = json_encode([
            'id_car' => $id,
            'immatriculation' => $immatriculation,
            'capacite' => $capacite,
            'modele' => $modele,
            'etat' => $etat,
        ], JSON_UNESCAPED_UNICODE);

        //Historique des action
        $requete2 = $bdd->prepare('INSERT INTO historique_action(id_car,adresse_ip,id_user,ancienne_valeur,nouvelle_valeur,nom_table,nom_action) VALUES(?,?,?,?,?,?,?)');
        $requete2->execute(array( $id, $adresse_ip,$_SESSION['id'], $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['mod'] = 1;

        header('Location:../../pages/car.php');
    } else {
        header('Location:../../pages/car.php');
    }

    // fermer la connexion
}

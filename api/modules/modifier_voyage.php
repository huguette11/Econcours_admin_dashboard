<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if(isset($_POST['id_voyage']) && isset($_POST['id_trajet']) && isset($_POST['id_car']) && isset($_POST['id_chauffeur']) && isset($_POST['date_depart']) && isset($_POST['heure_depart']) && isset($_POST['commentaire'])  ) {
        // connexion à la base de données
        include('connect_db.php');

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS 

        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_voyage']));
        $id_trajet = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_trajet'], ENT_QUOTES));
        $id_car = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_car'], ENT_QUOTES));
        $id_chauffeur = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_chauffeur'], ENT_QUOTES));
        $date_depart = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_depart'], ENT_QUOTES));
        $heure_depart = mysqli_real_escape_string($db, htmlspecialchars($_POST['heure_depart'], ENT_QUOTES));
        $statut = mysqli_real_escape_string($db, htmlspecialchars($_POST['statut'], ENT_QUOTES));
        $commentaire = mysqli_real_escape_string($db, htmlspecialchars($_POST['commentaire'], ENT_QUOTES));


        $date_depart = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $date_depart);
        $heure_depart  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $heure_depart);
        $statut  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $statut);
        $commentaire  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $commentaire);

        include('connect_db_pdo.php');

        // Récupérer les anciennes valeurs
        $requeteOld = $bdd->prepare("SELECT * FROM voyage WHERE id_voyage = ?");
        $requeteOld->execute(array($id));
        $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

        $requete = $bdd->prepare('UPDATE voyage SET id_trajet = ?, id_car = ?, id_chauffeur = ?, date_depart = ?, heure_depart = ?, statut = ?, commentaire = ? WHERE id_voyage = ?');
        $requete->execute(array($id_trajet, $id_car, $id_chauffeur, $date_depart, $heure_depart, $statut, $commentaire, $id));

        $id_user = $_SESSION['id'];
        $nom_table = "voyage";
        $nom_action = "Modification voyage";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        // Valeurs pour historique
        $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
        $nouvelle_valeur = json_encode([
            'id_voyage' => $id,
            'id_trajet' => $id_trajet,
            'id_car' => $id_car,
            'id_chauffeur' => $id_chauffeur,
            'date_depart' => $date_depart,
            'heure_depart' => $heure_depart,
            'statut' => $statut,
            'commentaire' => $commentaire,
        ], JSON_UNESCAPED_UNICODE);

        //Historique des action
        $requete2 = $bdd->prepare('INSERT INTO historique_action(id_voyage,adresse_ip,id_user,ancienne_valeur,nouvelle_valeur,nom_table,nom_action) VALUES(?,?,?,?,?,?,?)');
        $requete2->execute(array( $id, $adresse_ip,$_SESSION['id'], $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['mod'] = 1;

        header('Location:../../pages/voyage.php');
    } else {
        header('Location:../../pages/voyage.php');
    }

    // fermer la connexion
}

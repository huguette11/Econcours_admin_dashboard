<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (isset($_POST['id_trajet']) && isset($_POST['id_gare']) && isset($_POST['ville_depart']) && isset($_POST['ville_arrivee']) && isset($_POST['distance']) && isset($_POST['heure_depart']) && isset($_POST['heure_arrivee']) && isset($_POST['prix'])) {
        // connexion à la base de données
        include('connect_db.php');

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS 

        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_trajet']));
        $id_gare = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_gare'], ENT_QUOTES));
        $ville_depart = mysqli_real_escape_string($db, htmlspecialchars($_POST['ville_depart'], ENT_QUOTES));
        $ville_arrivee = mysqli_real_escape_string($db, htmlspecialchars($_POST['ville_arrivee'], ENT_QUOTES));
        $distance = mysqli_real_escape_string($db, htmlspecialchars($_POST['distance'], ENT_QUOTES));
        $heure_depart = mysqli_real_escape_string($db, htmlspecialchars($_POST['heure_depart'], ENT_QUOTES));
        $heure_arrivee = mysqli_real_escape_string($db, htmlspecialchars($_POST['heure_arrivee'], ENT_QUOTES));
        $prix = mysqli_real_escape_string($db, htmlspecialchars($_POST['prix'], ENT_QUOTES));


        $ville_depart = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $ville_depart);
        $ville_arrivee  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $ville_arrivee);
        $distance  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $distance);
        $heure_depart  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $heure_depart);
        $heure_arrivee  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $heure_arrivee);
        $prix  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $prix);

        include('connect_db_pdo.php');

        // Récupérer les anciennes valeurs
        $requeteOld = $bdd->prepare("SELECT * FROM trajet WHERE id_trajet = ?");
        $requeteOld->execute(array($id));
        $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

        $requete = $bdd->prepare('UPDATE trajet SET id_gare = ?, ville_depart = ?, ville_arrivee = ?, distance = ?, heure_depart = ?, heure_arrivee = ?, prix = ? WHERE id_trajet = ?');
        $requete->execute(array($id_gare, $ville_depart, $ville_arrivee, $distance, $heure_depart, $heure_arrivee, $prix, $id));

        $id_user = $_SESSION['id'];
        $nom_table = "trajet";
        $nom_action = "Modification trajet";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        // Valeurs pour historique
        $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
        $nouvelle_valeur = json_encode([
            'id_trajet' => $id,
            'ville_depart' => $ville_depart,
            'ville_arrivee' => $ville_arrivee,
            'distance' => $distance,
            'heure_depart' => $heure_depart,
            'heure_arrivee' => $heure_arrivee,
            'prix' => $prix,
        ], JSON_UNESCAPED_UNICODE);

        //Historique des action
        $requete2 = $bdd->prepare('INSERT INTO historique_action(id_trajet,adresse_ip,id_user,ancienne_valeur,nouvelle_valeur,nom_table,nom_action) VALUES(?,?,?,?,?,?,?)');
        $requete2->execute(array( $id, $adresse_ip,$_SESSION['id'], $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['mod'] = 1;

        header('Location:../../pages/trajet.php');
    } else {
        header('Location:../../pages/trajet.php');
    }

    // fermer la connexion
}

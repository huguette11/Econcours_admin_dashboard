<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (isset($_POST['id_chauffeur']) && isset($_POST['id_gare']) && isset($_POST['nom_chauffeur']) && isset($_POST['prenom']) && isset($_POST['telephone']) && isset($_POST['permis']) ) {
        // connexion à la base de données
        include('connect_db.php');

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS 

        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_chauffeur']));
        $id_gare = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_gare'], ENT_QUOTES));
        $nom_chauffeur = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom_chauffeur'], ENT_QUOTES));
        $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom'], ENT_QUOTES));
        $telephone = mysqli_real_escape_string($db, htmlspecialchars($_POST['telephone'], ENT_QUOTES));
        $permis = mysqli_real_escape_string($db, htmlspecialchars($_POST['permis'], ENT_QUOTES));


        $nom_chauffeur = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $nom_chauffeur);
        $prenom  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $prenom);
        $telephone  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $telephone);
        $permis  = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $permis);
    
        include('connect_db_pdo.php');


        // Récupérer les anciennes valeurs
        $requeteOld = $bdd->prepare("SELECT * FROM chauffeur WHERE id_chauffeur = ?");
        $requeteOld->execute(array($id));
        $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

        $requete = $bdd->prepare('UPDATE chauffeur SET id_gare = ?, nom_chauffeur = ?, prenom = ?, telephone = ?, permis = ? WHERE id_chauffeur = ?');
        $requete->execute(array($id_gare, $nom_chauffeur, $prenom, $telephone, $permis, $id));

        $id_user = $_SESSION['id'];
        $nom_table = "chauffeur";
        $nom_action = "Modification chauffeur";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        // Valeurs pour historique
        $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
        $nouvelle_valeur = json_encode([
            'id_chauffeur' => $id,
            'nom_chauffeur' => $nom_chauffeur,
            'prenom' => $prenom,
            'telephone' => $telephone,
            'permis' => $permis,
        ], JSON_UNESCAPED_UNICODE);

        //Historique des action
        $requete2 = $bdd->prepare('INSERT INTO historique_action(id_chauffeur,adresse_ip,id_user,ancienne_valeur,nouvelle_valeur,nom_table,nom_action) VALUES(?,?,?,?,?,?,?)');
        $requete2->execute(array( $id, $adresse_ip,$_SESSION['id'], $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action));



        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['mod'] = 1;

        header('Location:../../pages/chauffeur.php');
    } else {
        header('Location:../../pages/chauffeur.php');
    }

    // fermer la connexion
}

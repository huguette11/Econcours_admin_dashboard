<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (isset($_POST['id_utilisateur']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['date_naissance']) && isset($_POST['telephone']) && isset($_POST['email']) && isset($_POST['adresse']) && isset($_POST['username']) && isset($_POST['type_compte'])) {
        include('connect_db.php');

        // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
        // pour éliminer toute attaque de type injection SQL et XSS 
        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_utilisateur']));
        $nom = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom'], ENT_QUOTES));
        $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom'], ENT_QUOTES));
        $date_naissance = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_naissance'], ENT_QUOTES));
        $telephone = mysqli_real_escape_string($db, htmlspecialchars($_POST['telephone'], ENT_QUOTES));
        $email = mysqli_real_escape_string($db, htmlspecialchars($_POST['email'], ENT_QUOTES));
        $adresse = mysqli_real_escape_string($db, htmlspecialchars($_POST['adresse'], ENT_QUOTES));
        $username = mysqli_real_escape_string($db, htmlspecialchars($_POST['username'], ENT_QUOTES));
        $type_compte = mysqli_real_escape_string($db, htmlspecialchars($_POST['type_compte'], ENT_QUOTES));
        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_utilisateur'], ENT_QUOTES));

        $nom = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $nom);
        $prenom = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $prenom);
        $date_naissance = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $date_naissance);
        $telephone = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $telephone);
        $email = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $email);
        $adresse = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $adresse);
        $username = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $username);



        $requete = "SELECT count(*) FROM utilisateur where 
            (username = '" . $username . "' AND id_utilisateur != '" . $id . "')   ";
        $exec_requete = mysqli_query($db, $requete);
        $reponse = mysqli_fetch_array($exec_requete);
        $count = $reponse['count(*)'];


        if ($count == 0) {
            include('connect_db_pdo.php');

            // Récupérer les anciennes valeurs
            $requeteOld = $bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
            $requeteOld->execute(array($id));
            $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

            $requete = $bdd->prepare('UPDATE utilisateur SET nom = ?,prenom = ?,date_naissance = ?,telephone = ?,email = ?,adresse = ?,username = ?,type_compte = ? WHERE id_utilisateur=?');
            $requete->execute(array($nom, $prenom, $date_naissance, $telephone, $email, $adresse, $username, $type_compte, $id));

            $nom_table = "utilisateur";
            $nom_action = "Modification utilisateur";
            $adresse_ip = $_SERVER['REMOTE_ADDR'];

            // Valeurs pour historique
            $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
            $nouvelle_valeur = json_encode([
                'id_utilisateur' => $id,
                'nom' => $nom,
                'prenom' => $prenom,
                'date_naissance' => $date_naissance,
                'telephone' => $telephone,
                'email' => $email,
                'adresse' => $adresse,
                'username' => $username,
                'type_compte' => $type_compte,
            ], JSON_UNESCAPED_UNICODE);

            //Historique des action
            $requete2 = $bdd->prepare('INSERT INTO historique_action(id_utilisateur,adresse_ip,id_user,ancienne_valeur,nouvelle_valeur,nom_table,nom_action) VALUES(?,?,?,?,?,?,?)');
            $requete2->execute(array($_SESSION['id'], $adresse_ip, $id, $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action));

            // Fermer la connexion
            mysqli_close($db);
            $bdd = null;

            $_SESSION['mod'] = 1;

            header('Location:../../pages/utilisateur.php');
        } else {
            // Fermer la connexion
            mysqli_close($db);
            $_SESSION['imp'] = 1;

            header('Location:../../pages/utilisateur.php');
        }
    } else {
        header('Location:../../pages/utilisateur.php');
    }

    // fermer la connexion
}

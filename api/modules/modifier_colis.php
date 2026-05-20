<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (isset($_POST['num_cnib']) && isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['id_voyage']) && isset($_POST['reference']) && isset($_POST['contenu']) && isset($_POST['poids']) && isset($_POST['destinataire']) && isset($_POST['tel_destinataire']) && isset($_POST['frais_expedition'])) {

        // connexion à la base de données
        include('connect_db.php');

        $num_cnib = mysqli_real_escape_string($db, htmlspecialchars($_POST['num_cnib'], ENT_QUOTES));
        $nom = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom'], ENT_QUOTES));
        $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom'], ENT_QUOTES));
        $id_voyage = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_voyage'], ENT_QUOTES));
        $reference = mysqli_real_escape_string($db, htmlspecialchars($_POST['reference'], ENT_QUOTES));
        $contenu = mysqli_real_escape_string($db, htmlspecialchars($_POST['contenu'], ENT_QUOTES));
        $poids = mysqli_real_escape_string($db, htmlspecialchars($_POST['poids'], ENT_QUOTES));
        $destinataire = mysqli_real_escape_string($db, htmlspecialchars($_POST['destinataire'], ENT_QUOTES));
        $tel_destinataire = mysqli_real_escape_string($db, htmlspecialchars($_POST['tel_destinataire'], ENT_QUOTES));
        $frais_expedition = mysqli_real_escape_string($db, htmlspecialchars($_POST['frais_expedition'], ENT_QUOTES));

        $reference = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $reference);
        $contenu = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $contenu);
        $poids = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $poids);
        $destinataire = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $destinataire);
        $tel_destinataire = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $tel_destinataire);
        $frais_expedition = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $frais_expedition);

        include('connect_db_pdo.php');

        // Vérifier si le client existe déjà
        $req_client = $bdd->prepare("SELECT id_client FROM client WHERE num_cnib = ?");
        $req_client->execute([$num_cnib]);
        $client = $req_client->fetch(PDO::FETCH_ASSOC);

        if ($client) {
            $id_client = $client['id_client'];
        } else {
            // Créer le client
            $req_insert_client = $bdd->prepare("INSERT INTO client(num_cnib, nom, prenom) VALUES(?,?,?)");
            $req_insert_client->execute([$num_cnib, $nom, $prenom]);
            $id_client = $bdd->lastInsertId();
        }

        // Insérer le colis
        $requete = $bdd->prepare('INSERT INTO colis(id_client, id_voyage, reference, contenu, poids, destinataire, tel_destinataire, frais_expedition) VALUES(?,?,?,?,?,?,?,?)');
        $requete->execute(array($id_client, $id_voyage, $reference, $contenu, $poids, $destinataire, $tel_destinataire, $frais_expedition));

        //Historique des actions
        $requete = $bdd->prepare('SELECT id_colis FROM colis ORDER BY id_colis DESC LIMIT 1');
        $requete->execute(array());
        $id_colis = $requete->fetchColumn();

        $nom_table = "colis";
        $nom_action = "Ajout colis";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        $requete = $bdd->prepare('INSERT INTO historique_action(id_colis, adresse_ip, id_user, nom_table, nom_action) VALUES(?,?,?,?,?)');
        $requete->execute(array($id_colis, $adresse_ip, $_SESSION['id'], $nom_table, $nom_action));

        // Fermer la connexion
        mysqli_close($db);
        $bdd = null;

        $_SESSION['ajout'] = 1;
        header('Location:../../pages/colis.php');
    } else {
        header('Location:../../pages/colis.php');
    }
}
?>

<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    if (
        isset($_POST['id_reservation']) && isset($_POST['id_voyage']) &&
        isset($_POST['num_cnib']) && isset($_POST['nom']) && isset($_POST['prenom']) &&
        isset($_POST['num_place']) && isset($_POST['date_reservation']) &&
        isset($_POST['date_voyage']) && isset($_POST['montant']) &&
        isset($_POST['mode_paiement']) && isset($_POST['date_paiement'])
    ) {
        include('connect_db.php');

        // Sécurisation
        $id = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_reservation']));
        $id_voyage = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_voyage'], ENT_QUOTES));
        $num_cnib = mysqli_real_escape_string($db, htmlspecialchars($_POST['num_cnib'], ENT_QUOTES));
        $nom = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom'], ENT_QUOTES));
        $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom'], ENT_QUOTES));
        $num_place = mysqli_real_escape_string($db, htmlspecialchars($_POST['num_place'], ENT_QUOTES));
        $date_reservation = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_reservation'], ENT_QUOTES));
        $date_voyage = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_voyage'], ENT_QUOTES));
        $montant = mysqli_real_escape_string($db, htmlspecialchars($_POST['montant'], ENT_QUOTES));
        $mode_paiement = mysqli_real_escape_string($db, htmlspecialchars($_POST['mode_paiement'], ENT_QUOTES));
        $date_paiement = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_paiement'], ENT_QUOTES));

        // Nettoyage
        $champs = [&$num_place, &$date_reservation, &$date_voyage, &$montant, &$mode_paiement, &$date_paiement];
        foreach ($champs as &$val) {
            $val = str_ireplace(array("\r\n", '\r\n', "\r", "\n", '\r', '\n'), '<br>', $val);
        }

        include('connect_db_pdo.php');

        // Vérifier si le client existe déjà via son CNIB
        $checkClient = $bdd->prepare("SELECT id_client FROM client WHERE num_cnib = ?");
        $checkClient->execute([$num_cnib]);
        if ($checkClient->rowCount() > 0) {
            $client = $checkClient->fetch();
            $id_client = $client['id_client'];

            // Mise à jour nom / prénom si nécessaire
            $updateClient = $bdd->prepare("UPDATE client SET nom = ?, prenom = ? WHERE id_client = ?");
            $updateClient->execute([$nom, $prenom, $id_client]);
        } else {
            // Créer le client s’il n’existe pas
            $insertClient = $bdd->prepare("INSERT INTO client (num_cnib, nom, prenom) VALUES (?, ?, ?)");
            $insertClient->execute([$num_cnib, $nom, $prenom]);
            $id_client = $bdd->lastInsertId();
        }

        // Récupérer l’ancienne réservation
        $requeteOld = $bdd->prepare("SELECT * FROM reservation WHERE id_reservation = ?");
        $requeteOld->execute([$id]);
        $ancienne = $requeteOld->fetch(PDO::FETCH_ASSOC);

        // Mise à jour de la réservation
        $requete = $bdd->prepare('UPDATE reservation 
            SET id_voyage = ?, id_client = ?, num_place = ?, date_reservation = ?, 
                date_voyage = ?, montant = ?, mode_paiement = ?, date_paiement = ?
            WHERE id_reservation = ?');
        $requete->execute([$id_voyage, $id_client, $num_place, $date_reservation, $date_voyage, $montant, $mode_paiement, $date_paiement, $id]);

        // Historique
        $nom_table = "reservation";
        $nom_action = "Modification réservation";
        $adresse_ip = $_SERVER['REMOTE_ADDR'];

        $ancienne_valeur = json_encode($ancienne, JSON_UNESCAPED_UNICODE);
        $nouvelle_valeur = json_encode([
            'id_reservation' => $id,
            'id_voyage' => $id_voyage,
            'id_client' => $id_client,
            'num_place' => $num_place,
            'date_reservation' => $date_reservation,
            'date_voyage' => $date_voyage,
            'montant' => $montant,
            'mode_paiement' => $mode_paiement,
            'date_paiement' => $date_paiement
        ], JSON_UNESCAPED_UNICODE);

        $requete2 = $bdd->prepare('INSERT INTO historique_action(id_reservation, adresse_ip, id_user, ancienne_valeur, nouvelle_valeur, nom_table, nom_action)
                                   VALUES(?, ?, ?, ?, ?, ?, ?)');
        $requete2->execute([$id, $adresse_ip, $_SESSION['id'], $ancienne_valeur, $nouvelle_valeur, $nom_table, $nom_action]);

        mysqli_close($db);
        $bdd = null;

        $_SESSION['mod'] = 1;
        header('Location:../../pages/reservation.php');
    } else {
        header('Location:../../pages/reservation.php');
    }
}
?>

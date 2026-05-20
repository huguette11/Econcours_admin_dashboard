<?php
session_start();

if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:../../login.php?erreur=3');
    exit;
}

if (
    isset($_POST['num_cnib']) && isset($_POST['nom']) && isset($_POST['prenom']) &&
    isset($_POST['id_voyage']) && isset($_POST['num_place']) &&
    isset($_POST['date_reservation']) && isset($_POST['date_voyage']) &&
    isset($_POST['montant']) && isset($_POST['mode_paiement']) &&
    isset($_POST['date_paiement'])
) {
    // Connexion MySQLi
    include('connect_db.php');

    // Sécurisation des entrées
    $num_cnib = mysqli_real_escape_string($db, htmlspecialchars($_POST['num_cnib'], ENT_QUOTES));
    $nom = mysqli_real_escape_string($db, htmlspecialchars($_POST['nom'], ENT_QUOTES));
    $prenom = mysqli_real_escape_string($db, htmlspecialchars($_POST['prenom'], ENT_QUOTES));
    $id_voyage = mysqli_real_escape_string($db, htmlspecialchars($_POST['id_voyage'], ENT_QUOTES));
    $num_place = mysqli_real_escape_string($db, htmlspecialchars($_POST['num_place'], ENT_QUOTES));
    $date_reservation = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_reservation'], ENT_QUOTES));
    $date_voyage = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_voyage'], ENT_QUOTES));
    $montant = mysqli_real_escape_string($db, htmlspecialchars($_POST['montant'], ENT_QUOTES));
    $mode_paiement = mysqli_real_escape_string($db, htmlspecialchars($_POST['mode_paiement'], ENT_QUOTES));
    $date_paiement = mysqli_real_escape_string($db, htmlspecialchars($_POST['date_paiement'], ENT_QUOTES));

    // Nettoyage des sauts de ligne
    $champs = [&$num_place, &$date_reservation, &$date_voyage, &$montant, &$mode_paiement, &$date_paiement];
    foreach ($champs as &$champ) {
        $champ = str_ireplace(["\r\n", '\r\n', "\r", "\n", '\r', '\n'], '<br>', $champ);
    }

    // Connexion PDO
    include('connect_db_pdo.php');

    // 🔹 Étape 1 : Vérifier si le client existe déjà via le numéro CNIB
    $stmt = $bdd->prepare("SELECT id_client FROM client WHERE num_cnib = ?");
    $stmt->execute([$num_cnib]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
        // Client existant
        $id_client = $client['id_client'];
    } else {
        // 🔹 Étape 2 : Insérer le client s’il n’existe pas
        $insert_client = $bdd->prepare("INSERT INTO client (num_cnib, nom, prenom) VALUES (?, ?, ?)");
        $insert_client->execute([$num_cnib, $nom, $prenom]);
        $id_client = $bdd->lastInsertId();
    }

    // 🔹 Étape 3 : Insérer la réservation
    $requete = $bdd->prepare('INSERT INTO reservation(id_client, id_voyage, num_place, date_reservation, date_voyage, montant, mode_paiement, date_paiement)
                              VALUES(?,?,?,?,?,?,?,?)');
    $requete->execute([$id_client, $id_voyage, $num_place, $date_reservation, $date_voyage, $montant, $mode_paiement, $date_paiement]);

    // 🔹 Étape 4 : Historiser l’action
    $id_reservation = $bdd->lastInsertId();
    $nom_table = "reservation";
    $nom_action = "Ajout réservation";
    $adresse_ip = $_SERVER['REMOTE_ADDR'];

    $historique = $bdd->prepare('INSERT INTO historique_action(id_reservation, adresse_ip, id_user, nom_table, nom_action)
                                 VALUES(?,?,?,?,?)');
    $historique->execute([$id_reservation, $adresse_ip, $_SESSION['id'], $nom_table, $nom_action]);

    // 🔹 Étape 5 : Nettoyage
    mysqli_close($db);
    $bdd = null;

    $_SESSION['ajout'] = 1;
    header('Location:../../pages/reservation.php');
    exit;
} else {
    header('Location:../../pages/reservation.php');
    exit;
}
?>

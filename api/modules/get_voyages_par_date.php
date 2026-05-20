<?php
include('connect_db.php'); // connexion MySQLi

if (isset($_GET['date_voyage'])) {
    $date_voyage = mysqli_real_escape_string($db, $_GET['date_voyage']);

    $sql = "
        SELECT 
            v.id_voyage,
            CONCAT(t.ville_depart, ' - ', t.ville_arrivee, ' (', t.heure_depart, ')') AS trajet,
            t.prix,
            c.capacite,
            (
                SELECT COUNT(*) 
                FROM reservation r 
                WHERE r.id_voyage = v.id_voyage AND r.suppression = 'Non'
            ) AS places_reservees
        FROM voyage v
        JOIN trajet t ON v.id_trajet = t.id_trajet
        JOIN car c ON v.id_car = c.id_car
        WHERE v.date_depart = '$date_voyage' AND v.suppression = 'Non'
    ";

    $result = mysqli_query($db, $sql);
    $voyages = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $voyages[] = $row;
    }

    echo json_encode($voyages);
}
?>

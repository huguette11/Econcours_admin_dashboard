<?php
include('connect_db_pdo.php');

if(isset($_GET['id_trajet'])) {
    $id_trajet = intval($_GET['id_trajet']);

    $stmt = $bdd->prepare("
        SELECT v.id_voyage, v.date_depart, c.immatriculation
        FROM voyage v
        JOIN car c ON v.id_car = c.id_car
        WHERE v.id_trajet = ? AND v.suppression='Non'
        LIMIT 1
    ");
    $stmt->execute([$id_trajet]);
    $voyage = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($voyage);
}
?>

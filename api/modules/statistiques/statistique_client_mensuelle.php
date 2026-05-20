<?php
header('Content-Type: application/json');

// Connexion
include('../connect_db.php');

$sql = "SELECT MONTH(date_reservation) as mois, COUNT(*) as total 
        FROM reservation where suppression='non'
        GROUP BY mois";

$result = mysqli_query($db, $sql);

$data = array_fill(1, 12, 0); // 12 mois initialisés à 0

while ($row = mysqli_fetch_assoc($result)) {
    $data[(int)$row['mois']] = (int)$row['total'];
}

echo json_encode(array_values($data));
exit;

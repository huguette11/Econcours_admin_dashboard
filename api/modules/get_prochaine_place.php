<?php
include 'connect_db.php'; // Connexion MySQLi

header('Content-Type: application/json');

if (!isset($_GET['id_voyage']) || empty($_GET['id_voyage'])) {
    echo json_encode(['success' => false, 'message' => 'ID du voyage manquant']);
    exit;
}

$id_voyage = intval($_GET['id_voyage']);

// 🔹 Récupérer la capacité via la table car
$sql_voyage = "
    SELECT c.capacite 
    FROM voyage v
    JOIN car c ON v.id_car = c.id_car
    WHERE v.id_voyage = $id_voyage AND v.suppression = 'Non'
";

$verif = $db->query($sql_voyage);
if (!$verif || $verif->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Voyage introuvable']);
    exit;
}

$voyage = $verif->fetch_assoc();
$capacite = intval($voyage['capacite']);

// 🔹 Récupérer les places déjà réservées
$sql = "SELECT num_place FROM reservation WHERE id_voyage = $id_voyage AND suppression = 'Non' ORDER BY num_place ASC";
$result = $db->query($sql);

$places_occupees = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $places_occupees[] = intval($row['num_place']);
    }
}

// 🔹 Calculer la prochaine place libre
$prochaine_place = null;
for ($i = 1; $i <= $capacite; $i++) {
    if (!in_array($i, $places_occupees)) {
        $prochaine_place = $i;
        break;
    }
}

if ($prochaine_place === null) {
    echo json_encode(['success' => false, 'message' => 'Aucune place disponible']);
} else {
    echo json_encode(['success' => true, 'prochaine_place' => $prochaine_place]);
}
?>

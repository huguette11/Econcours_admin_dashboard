<?php
header('Content-Type: application/json');
require_once 'connect_db.php';

if (!isset($_GET['id_trajet'])) {
    echo json_encode(['success' => false, 'message' => 'ID trajet manquant.']);
    exit;
}

$id_trajet = intval($_GET['id_trajet']);
$sql = "SELECT heure_depart FROM trajet WHERE id_trajet = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param('i', $id_trajet);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'success' => true,
        'heure_depart' => $row['heure_depart']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Trajet introuvable.']);
}

$stmt->close();
$db->close();
?>

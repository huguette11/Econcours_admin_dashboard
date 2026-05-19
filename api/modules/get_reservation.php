<?php
header('Content-Type: application/json');
include '../../connect_db_pdo.php'; // ta connexion PDO

if (isset($_GET['id_reservation'])) {
    $id_reservation = $_GET['id_reservation'];

    $sql = "SELECT 
                r.id_reservation,
                r.date_reservation,
                r.date_voyage,
                r.id_voyage,
                r.id_client,
                r.num_place,
                r.montant,
                r.mode_paiement,
                r.date_paiement,
                t.prix,
                CONCAT(t.ville_depart, ' - ', t.ville_arrivee, ' (', t.heure_depart, ')') AS trajet
            FROM reservation r
            JOIN voyage v ON r.id_voyage = v.id_voyage
            JOIN trajet t ON v.id_trajet = t.id_trajet
            WHERE r.id_reservation = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_reservation]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
        echo json_encode([
            'success' => true,
            'reservation' => $reservation
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Réservation introuvable']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID réservation manquant']);
}
?>


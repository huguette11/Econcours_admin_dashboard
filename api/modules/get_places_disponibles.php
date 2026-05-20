<?php
include('connect_db.php');

if (isset($_GET['id_voyage'])) {
    $id_voyage = intval($_GET['id_voyage']);

    // Récupérer la capacité totale du car
    $sql = "SELECT car.capacite 
            FROM voyage 
            INNER JOIN car ON voyage.id_car = car.id_car 
            WHERE voyage.id_voyage = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id_voyage);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $capacite = intval($row['capacite']);

        // Récupérer les places déjà réservées pour ce voyage
        $sql2 = "SELECT num_place FROM reservation WHERE id_voyage = ?";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bind_param("i", $id_voyage);
        $stmt2->execute();
        $result2 = $stmt2->get_result();

        $places_occupees = [];
        while ($r = $result2->fetch_assoc()) {
            $places_occupees[] = intval($r['num_place']);
        }

        // Générer la liste des places disponibles
        $places_disponibles = [];
        for ($i = 1; $i <= $capacite; $i++) {
            if (!in_array($i, $places_occupees)) {
                $places_disponibles[] = $i;
            }
        }

        echo json_encode($places_disponibles);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}

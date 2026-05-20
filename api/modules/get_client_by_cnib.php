<?php

include 'connect_db_pdo.php';

header('Content-Type: application/json');

if (!isset($_GET['num_cnib']) || empty($_GET['num_cnib'])) {
    echo json_encode(['success' => false, 'message' => 'Numéro CNIB manquant']);
    exit;
}

$num_cnib = trim($_GET['num_cnib']);

try {
    $stmt = $bdd->prepare("SELECT id_client, nom, prenom FROM client WHERE num_cnib = ?");
    $stmt->execute([$num_cnib]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
        echo json_encode([
            'success' => true,
            'id_client' => $client['id_client'],
            'nom' => $client['nom'],
            'prenom' => $client['prenom']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun client trouvé']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur serveur : ' . $e->getMessage()]);
}
?>

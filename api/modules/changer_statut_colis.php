<?php
include 'connect_db.php'; // ton fichier de connexion

if (isset($_POST['id_colis'])) {
    $id = intval($_POST['id_colis']);

    // Vérifier le statut actuel
    $query = $db->query("SELECT statut FROM colis WHERE id_colis = $id");
    $colis = $query->fetch_assoc();

    if ($colis) {
        $nouveau_statut = $colis['statut'] === 'Enregistré' ? 'Récupéré' : 'Enregistré';

        $update = $db->query("UPDATE colis SET statut='$nouveau_statut' WHERE id_colis=$id");

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Colis non trouvé']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
include('connect_db.php');

if (!isset($_GET['id_client'])) {
    echo json_encode(['success' => false, 'message' => 'ID client manquant']);
    exit;
}

$id_client = intval($_GET['id_client']);

$sql = "SELECT num_cnib, nom, prenom FROM client WHERE id_client = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $id_client);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'Client introuvable']);
}

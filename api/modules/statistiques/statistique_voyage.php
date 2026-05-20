<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/../connect_db.php');

$sql = "SELECT COUNT(*) as total FROM voyage WHERE suppression='non'";
$result = $db->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode(['total' => 0]);
}


<?php
require_once(__DIR__ . '/../connect_db.php');

$sql = "SELECT count(*) as total FROM client WHERE suppression='non'";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total']]);
?>

<?php
include('connect_db.php');

if(isset($_POST['id_voyage'])){
    $id_voyage = mysqli_real_escape_string($db, $_POST['id_voyage']);
    $query = "SELECT t.prix FROM voyage v JOIN trajet t ON v.id_trajet = t.id_trajet WHERE v.id_voyage = $id_voyage";
    $res = mysqli_query($db, $query);
    if($row = mysqli_fetch_assoc($res)){
        echo json_encode(['prix' => $row['prix']]);
    }
}

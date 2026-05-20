<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
include('connect_db.php');

// Vérifier si un id_reservation est passé
if (!isset($_GET['id_reservation'])) {
    die("Réservation introuvable");
}

$id_reservation = intval($_GET['id_reservation']);


// Récupérer les infos de la réservation
$query = "SELECT r.id_reservation, r.num_place,
                 v.date_depart, v.heure_depart,
                 t.ville_depart, t.ville_arrivee, 
                 cli.nom, cli.prenom,
                 cli.telephone, cli.num_cnib, 
                 car.immatriculation
          FROM reservation r
          JOIN voyage v ON r.id_voyage = v.id_voyage
          JOIN trajet t ON v.id_trajet = t.id_trajet
          JOIN client cli ON r.id_client = cli.id_client
          
          JOIN car ON v.id_car = car.id_car
          WHERE r.id_reservation = $id_reservation";

$result = mysqli_query($db, $query);
$reservation = mysqli_fetch_assoc($result);

if (!$reservation) {
    die("Réservation introuvable !");
}

// Construire le HTML du ticket
$html = '
<style>
.ticket {
    font-family: Arial, sans-serif;
    border: 1px solid #000;
    padding: 20px;
    width: 100%;
}
h2 {
    text-align: center;
}
</style>

<div class="ticket">
    <h2>TICKET DE VOYAGE</h2>
    <p><strong>Nom du client :</strong> '.$reservation['nom'].' '.$reservation['prenom'].'</p>
    <p><strong>Téléphone :</strong> '.$reservation['telephone'].'</p>
    <p><strong>Numéro CNIB :</strong> '.$reservation['num_cnib'].'</p>
    <p><strong>Numéro de place :</strong> '.$reservation['num_place'].'</p>
    <p><strong>Immatriculation du car :</strong> '.$reservation['immatriculation'].'</p>
    <p><strong>Trajet :</strong> '.$reservation['ville_depart'].' - '.$reservation['ville_arrivee'].'</p>
    <p><strong>Date départ :</strong> '.$reservation['date_depart'].' à '.$reservation['heure_depart'].'</p>
</div>
';

// Générer le PDF
try {
    $pdf = new Html2Pdf('P', 'A4', 'fr');
    $pdf->writeHTML($html);
    $pdf->output('ticket_reservation_'.$id_reservation.'.pdf', 'D'); // "D" = download
} catch (Html2PdfException $e) {
    echo $e->getMessage();
}

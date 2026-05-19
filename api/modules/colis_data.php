<?php
session_start();
$_SESSION['id'] = 1;
$_SESSION['type_compte'] = "Administrateur";
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
    session_unset();
    session_destroy();
    header('Location:./../index.php?erreur=3');
} else {
    $table = <<<EOT
        (
            SELECT 
                ROW_NUMBER() OVER(ORDER BY c.id_colis) as num_row,
                c.id_colis,
                c.reference,
                c.poids,
                c.contenu,
                c.destinataire,
                c.tel_destinataire,
                c.frais_expedition,
                c.statut,
                CONCAT(t.ville_depart, ' - ', t.ville_arrivee, ' (', t.heure_depart, ')') as trajet, 
                v.date_depart,
                CONCAT(client.nom, ' ', client.prenom) as nom,
                car.immatriculation,
                v.id_voyage,
                client.id_client,
                t.id_trajet,
                car.id_car
            FROM colis c
            JOIN client ON c.id_client = client.id_client
            JOIN voyage v ON c.id_voyage = v.id_voyage
            JOIN trajet t ON v.id_trajet = t.id_trajet
            JOIN car ON v.id_car = car.id_car
            WHERE c.suppression = 'Non'
        ) tem
        EOT;



    $primaryKey = 'id_colis';

    $columns = array(         
        array( 'db' => 'num_row', 'dt' => 0 ),
        array( 'db' => 'reference',   'dt' => 1 ),
        array( 'db' => 'contenu', 'dt' => 2 ),
        array( 'db' => 'poids', 'dt' => 3 ),
        array( 'db' => 'nom',   'dt' => 4 ),
        array( 'db' => 'destinataire', 'dt' => 5 ),
        array( 'db' => 'tel_destinataire', 'dt' => 6 ),
        array( 'db' => 'trajet',   'dt' => 7 ),
        array( 'db' => 'date_depart',   'dt' => 8 ),
        array( 'db' => 'immatriculation',   'dt' => 9 ),
        array( 'db' => 'frais_expedition',   'dt' => 10 ),
        array( 'db' => 'statut',   'dt' => 11 ),

        array( 'db' => 'id_colis',   'dt' => 14 ),
        array( 'db' => 'id_client',   'dt' => 15 ),
        array( 'db' => 'id_voyage',   'dt' => 16 ),
        array( 'db' => 'id_car',   'dt' => 17 ),
        array( 'db' => 'id_trajet',   'dt' => 18  ),
    );

    include('connect_db_data.php');

    require('DataTables/ssp.class.php');
    echo json_encode(
        SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns)
    );
}
?>
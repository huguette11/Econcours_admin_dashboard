<?php 
    session_start();
    $_SESSION['id']=1;
    $_SESSION['type_compte'] = "Administrateur";
    if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
        session_unset();
        session_destroy();
        header('Location:./../index.php?erreur=3');
    } 
    else 
    {
        $table = <<<EOT
        (
            SELECT 
                ROW_NUMBER() OVER(ORDER BY r.id_reservation) as num_row,
                r.id_reservation,
                r.num_place,
                r.date_reservation,
                r.date_voyage,
                r.montant,
                r.mode_paiement,
                r.date_paiement,
                CONCAT(t.ville_depart, ' - ', t.ville_arrivee, ' (', t.heure_depart, ')') as trajet,
                CONCAT(c.nom, ' ', c.prenom) as nom,
                c.id_client,
                r.id_voyage,
                v.id_trajet
            FROM reservation r
            JOIN voyage v ON r.id_voyage = v.id_voyage
            JOIN trajet t ON v.id_trajet = t.id_trajet
            JOIN client c ON r.id_client = c.id_client
            WHERE r.suppression = 'Non'
        ) tem
        EOT;

                

        $primaryKey = 'id_reservation';

        $columns = array(         
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'trajet',   'dt' => 1 ),
            array( 'db' => 'nom', 'dt' => 2 ),
            array( 'db' => 'num_place',   'dt' => 3 ),
            array( 'db' => 'date_reservation',   'dt' => 4 ),
            array( 'db' => 'date_voyage', 'dt' => 5 ),
            array( 'db' => 'montant',   'dt' => 6 ),
            array( 'db' => 'mode_paiement',   'dt' => 7 ),
            array( 'db' => 'date_paiement',   'dt' => 8 ),

            array( 'db' => 'id_reservation',   'dt' => 12),
            array( 'db' => 'id_voyage',   'dt' => 13 ),
            array( 'db' => 'id_client',   'dt' => 14 ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>



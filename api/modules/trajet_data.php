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
                ROW_NUMBER() OVER(ORDER BY trajet.id_trajet) as num_row,
                trajet.id_trajet,
                trajet.ville_depart,
                trajet.ville_arrivee,
                trajet.distance,
                trajet.heure_depart,
                trajet.heure_arrivee,
                trajet.prix,
                gare.nom,
                gare.id_gare
            FROM trajet
            JOIN gare ON trajet.id_gare = gare.id_gare
            WHERE trajet.suppression = 'Non'
        ) tem
        EOT;

        $primaryKey = 'id_trajet';

        $columns = array(         
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'nom',   'dt' => 1 ),
            array( 'db' => 'ville_depart', 'dt' => 2 ),
            array( 'db' => 'ville_arrivee', 'dt' => 3 ),
            array( 'db' => 'distance',   'dt' => 4 ),
            array( 'db' => 'heure_depart',   'dt' => 5 ),
            array( 'db' => 'heure_arrivee',   'dt' => 6 ),
            array( 'db' => 'prix',   'dt' => 7 ),

            array( 'db' => 'id_trajet',   'dt' => 10 ),
            array( 'db' => 'id_gare',   'dt' => 11 ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>



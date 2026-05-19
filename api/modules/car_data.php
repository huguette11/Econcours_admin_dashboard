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
                ROW_NUMBER() OVER(ORDER BY car.id_car) as num_row,
                car.id_car,
                car.immatriculation,
                car.modele,
                car.capacite,
                car.etat,
                gare.nom,
                gare.id_gare
            FROM car
            JOIN gare ON car.id_gare = gare.id_gare
            WHERE car.suppression = 'Non'
        ) tem
        EOT;

        $primaryKey = 'id_car';

        $columns = array(
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'nom',   'dt' => 1 ),
            array( 'db' => 'immatriculation', 'dt' => 2 ),
            array( 'db' => 'modele', 'dt' => 3 ),
            array( 'db' => 'capacite',   'dt' => 4 ),
            array( 'db' => 'etat',   'dt' => 5 ),


            array( 'db' => 'id_car',   'dt' => 8 ),
            array( 'db' => 'id_gare',   'dt' => 9 ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>



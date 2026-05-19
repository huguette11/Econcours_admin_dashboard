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
                ROW_NUMBER() OVER(ORDER BY id_gare) as num_row,
                id_gare,
                nom,
                adresse,
                telephone,
                email
            FROM gare where suppression = 'non'
        ) tem
        EOT;

        $primaryKey = 'id_gare';

        $columns = array(
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'nom', 'dt' => 1 ),
            array( 'db' => 'adresse',   'dt' => 2 ),
            array( 'db' => 'telephone',   'dt' => 3 ),
            array( 'db' => 'email',   'dt' => 4  ),

            array( 'db' => 'id_gare',   'dt' => 7  ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>

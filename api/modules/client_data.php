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
                ROW_NUMBER() OVER(ORDER BY id_client) as num_row,
                id_client,
                nom,
                prenom,
                num_cnib,
                telephone,
                email
            FROM client where suppression = 'non'
        ) tem
        EOT;

        $primaryKey = 'id_client';

        $columns = array(
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'nom', 'dt' => 1 ),
            array( 'db' => 'prenom',   'dt' => 2 ),
            array( 'db' => 'num_cnib',   'dt' => 3 ),
            array( 'db' => 'telephone',   'dt' => 4 ),
            array( 'db' => 'email',   'dt' => 5  ),

            array( 'db' => 'id_client',   'dt' => 8 ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>

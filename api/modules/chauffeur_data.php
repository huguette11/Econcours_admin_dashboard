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
                ROW_NUMBER() OVER(ORDER BY chauffeur.id_chauffeur) as num_row,
                chauffeur.id_chauffeur,
                chauffeur.nom_chauffeur,
                chauffeur.prenom,
                chauffeur.telephone,
                chauffeur.permis,
                gare.nom,
                gare.id_gare
            FROM chauffeur 
            JOIN gare ON chauffeur.id_gare = gare.id_gare 
            WHERE chauffeur.suppression = 'Non'
        ) tem
        EOT;

        $primaryKey = 'id_chauffeur';

        $columns = array(
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'nom', 'dt' => 1 ),
            array( 'db' => 'nom_chauffeur', 'dt' => 2 ),
            array( 'db' => 'prenom',   'dt' => 3 ),
            array( 'db' => 'telephone',   'dt' => 4 ),
            array( 'db' => 'permis',   'dt' => 5  ),

            array( 'db' => 'id_chauffeur',   'dt' => 8  ),
            array( 'db' => 'id_gare',   'dt' => 9  ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>

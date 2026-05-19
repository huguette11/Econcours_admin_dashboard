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
                ROW_NUMBER() OVER(ORDER BY v.id_voyage) as num_row,
                v.id_voyage,
                v.date_depart,
                v.heure_depart,
                v.statut,
                v.commentaire,
                CONCAT(t.ville_depart, ' - ', t.ville_arrivee, ' (', t.heure_depart, ')') as trajet,
                CONCAT(c.nom_chauffeur, ' ', c.prenom, ' (', c.telephone, ')') as nom,
                car.immatriculation,
                c.id_chauffeur,
                t.id_trajet,
                car.id_car
            FROM voyage v
            JOIN trajet t ON v.id_trajet = t.id_trajet
            JOIN chauffeur c ON v.id_chauffeur = c.id_chauffeur
            JOIN car ON v.id_car = car.id_car
            WHERE v.suppression = 'Non'
        ) tem
        EOT;

                

        $primaryKey = 'id_voyage';

        $columns = array(         
            array( 'db' => 'num_row', 'dt' => 0 ),
            array( 'db' => 'trajet',   'dt' => 1 ),
            array( 'db' => 'immatriculation', 'dt' => 2 ),
            array( 'db' => 'nom', 'dt' => 3 ),
            array( 'db' => 'date_depart',   'dt' => 4 ),
            array( 'db' => 'heure_depart',   'dt' => 5 ),
            array( 'db' => 'statut',   'dt' => 6 ),
            array( 'db' => 'commentaire',   'dt' => 7 ),

            array( 'db' => 'id_voyage',   'dt' => 10 ),
            array( 'db' => 'id_trajet',   'dt' => 11 ),
            array( 'db' => 'id_car',   'dt' => 12 ),
            array( 'db' => 'id_chauffeur',   'dt' => 13 ),
        );

        include('connect_db_data.php');

        require( 'DataTables/ssp.class.php' );
        echo json_encode(
            SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns )
        );
    }
?>



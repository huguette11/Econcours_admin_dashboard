<?php
session_start();
if (empty($_SESSION['id']) || ($_SESSION['type_compte'] != "Administrateur")) {
  session_unset();
  session_destroy();
  header('Location:./../index.php?erreur=3');
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BITRAVEL - client</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include("inclusions_haut.php") ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php include("menus/menu_admin.php") ?>
        <?php include("alerts/alert_car.php") ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            
            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid"></div>
                <!-- Topbar -->
                <?php include("entete.php") ?>

                <!-- End of Topbar -->

                <div class="header">
                    <div class="container-fluid">
                        <div class="header-body">
                            <div class="row align-items-center py-4">
                                <div class="text-left">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ajouter_car">Ajouter un car <i class="fa  fa-plus "></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <!-- Card header -->
                                <div class="card-header border-0">
                                    <h3 class="mb-0">Liste des cars</h3>
                                </div>
                                <!-- Light table -->
                                <div class="table-responsive">
                                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Gare</th>
                                                <th class="text-center">Immatriculation</th>
                                                <th class="text-center">Modèle</th>
                                                <th class="text-center">Capacité</th>
                                                <th class="text-center">État</th>
                                                <th class="text-center">Modifier</th>
                                                <th class="text-center">Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Gare</th>
                                                <th class="text-center">Immatriculation</th>
                                                <th class="text-center">Modèle</th>
                                                <th class="text-center">Capacité</th>
                                                <th class="text-center">État</th>
                                                <th class="text-center">Modifier</th>
                                                <th class="text-center">Supprimer</th>
                                            </tr>
                                        </tfoot>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Footer -->
                    <?php include("footer.php") ?>
                </div>
            </div>

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->

    <?php include("inclusions_bas.php") ?>
    <script type="text/javascript" src="DataTables/data_table_car.js?version=1.0"></script>
    <script src="assets/js/script.js"></script>
    <?php include('modals/modal_car.php'); ?>


</body>

</html>
<?php } ?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Liste des concours</title>

    <!-- Fonts -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- CSS -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php include("inclusions_haut.php") ?>

</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("menu_admin.php") ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <!-- Topbar -->
                <?php include("entete.php") ?>

                <div class="container-fluid">

                    <!-- HEADER -->
                    <div class=" align-items-center justify-content-between mb-4">

                        <button
                            type="button"
                            class="btn btn-primary shadow-sm"
                            data-toggle="modal"
                            data-target="#ajouter_concours">

                            <i class="fas fa-plus fa-sm text-white-50"></i>
                            Ajouter un concours
                        </button>

                    </div>

                    <!-- TABLE -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <h3 class="mb-0 ">
                                Liste des concours
                            </h3>
                        </div>

                        <div class="card-body">

                            <div class="table-responsive">

                                <table
                                    class="table table-bordered table-hover"
                                    id="dataTable"
                                    width="100%"
                                    cellspacing="0">

                                    <thead class="thead-light">

                                        <tr>

                                            <th class="text-center">N°</th>

                                            <th class="text-center">
                                                Nom
                                            </th>

                                            <th class="text-center">
                                                Type
                                            </th>

                                            <th class="text-center">
                                                Catégorie
                                            </th>

                                            <th class="text-center">
                                                Frais
                                            </th>

                                            <th class="text-center">
                                                Postes
                                            </th>

                                            <th class="text-center">
                                                Année
                                            </th>

                                            <th class="text-center">
                                                Début
                                            </th>

                                            <th class="text-center">
                                                Fin
                                            </th>

                                            <th class="text-center">
                                                Statut
                                            </th>

                                            <th class="text-center">
                                                Modifier
                                            </th>

                                            <th class="text-center">
                                                Supprimer
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody id="concoursTableBody">

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Footer -->
            <?php include("footer.php") ?>

        </div>

    </div>

    <!-- Scroll -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- JS -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="../js/sb-admin-2.min.js"></script>

    <!-- DataTables -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>

    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Modal -->
    <?php include("modals/modal_concours.php"); ?>

    <!-- CONTROLLER -->
    <script type="module">

        import ConcoursController from "../Controllers/ConcoursController.js";

        document.addEventListener("DOMContentLoaded", async () => {

            await ConcoursController.initDataTable();

        });

    </script>

</body>

</html>
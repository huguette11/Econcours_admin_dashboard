<?php
session_start();
require_once('../api/modules/connect_db_pdo.php');

// Vérification de la session
if (!isset($_SESSION['id'])) {
    // Redirection ou message d’erreur si l’utilisateur n’est pas connecté
    die("Accès non autorisé. Veuillez vous connecter.");
}

$id_user = $_SESSION['id'];

// Requête pour récupérer les infos du profil
$stmt = $bdd->prepare("SELECT * FROM utilisateur WHERE id_utilisateur  = ?");
$stmt->execute([$id_user]);
$profil = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profil) {
    die("Profil introuvable.");
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

        <title>SB Admin 2 - Tables</title>

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
            <?php include("alerts/alert_utilisateur.php") ?>
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

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <!-- Card header -->
                                    <div class="container py-5" style="max-width: 800px; min-height: 100vh;">
                                        <div class="bg-secondary shadow rounded p-4">

                                            <h2 class="text-center mb-4">Mon Profil</h2>

                                            <div class="row">
                                                <!-- Colonne gauche -->
                                                <div class="col-md-6">
                                                    <p><strong>Nom :</strong> <?= htmlspecialchars($profil['nom']) ?></p>
                                                    <p><strong>Prénom :</strong> <?= htmlspecialchars($profil['prenom']) ?></p>
                                                    <p><strong>Email :</strong> <?= htmlspecialchars($profil['email']) ?></p>
                    
                                                </div>

                                                <!-- Colonne droite -->
                                                <div class="col-md-6">

                                                    <p><strong>Adresse :</strong> <?= htmlspecialchars($profil['adresse']) ?></p>
                                                    <p><strong>Username :</strong> <?= htmlspecialchars($profil['username']) ?></p>
                                                    <p><strong>Type de compte :</strong> <?= htmlspecialchars($profil['type_compte']) ?></p>
                                                </div>
                                            </div>

                                            <div class="text-center mt-4">
                                                <button class="btn btn-sm btn-primary px-4" data-toggle="modal" data-target="#modalProfil">
                                                    <i class="fa fa-pencil"></i> Modifier mes informations
                                                </button>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button class="btn btn-warning" data-toggle="modal" data-target="#modalPassword">
                                                    <i class="fa fa-lock"></i> Modifier le mot de passe
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer py-4">

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

        <!-- Logout Modal-->
        <!-- <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div> -->

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
        <script src="assets/js/script.js"></script>
        <?php include('modals/modal_profil.php'); ?>



    </body>

    </html>
<?php } ?>
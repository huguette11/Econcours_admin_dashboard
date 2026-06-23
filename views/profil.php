<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Profil</title>

    <!-- Custom fonts for this template -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../pages/assets/css/style.css">

    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include("inclusions_haut.php") ?>
</head>



<body id="page-top">
    <div id="wrapper">

        <?php include("menu_admin.php") ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <div class="container-fluid">
                    <!-- Topbar -->
                    <?php include("entete.php") ?>

                    <main class="dashboard">

                        <div class="dashboard-container">

                            <!-- HERO -->
                            <div class="profile-hero">
                                <div class="profile-avatar" id="profileAvatar"></div>

                                <div class="profile-info">
                                    <h2 id="adminNomComplet">Administrateur</h2>
                                    <p id="adminRole">-</p>
                                </div>
                            </div>

                            <!-- CARD UNIQUE -->
                            <div class="profile-card">

                                <div class="profile-card-header">
                                    <i class="fas fa-user"></i>
                                    <span>Informations administrateur</span>
                                </div>

                                <div class="profile-grid">

                                    <div class="profile-item">
                                        <label>Nom</label>
                                        <span id="profil_nom">-</span>
                                    </div>

                                    <div class="profile-item">
                                        <label>Prénom</label>
                                        <span id="profil_prenom">-</span>
                                    </div>

                                    <div class="profile-item">
                                        <label>Email</label>
                                        <span id="profil_email">-</span>
                                    </div>

                                    <div class="profile-item">
                                        <label>Téléphone</label>
                                        <span id="profil_tel">-</span>
                                    </div>

                                    <div class="profile-item">
                                        <label>Rôle</label>
                                        <span id="profil_role">-</span>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </main>
                </div>
            </div>
        </div>
    </div>
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

    <script type="module">
        import AdminController
        from "../Controllers/AdminController.js";

        document.addEventListener(
            "DOMContentLoaded",
            () => {
                AdminController.loadProfile();
            }
        );
    </script>

</body>

</html>
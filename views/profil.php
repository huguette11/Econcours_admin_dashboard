<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Mon profil - E-CONCOURS</title>

    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900"
        rel="stylesheet">

    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../pages/assets/css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php include("inclusions_haut.php") ?>

</head>


<body id="page-top" class="admin-profile-page">

    <div id="wrapper">

        <?php include("menu_admin.php") ?>


        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php include("entete.php") ?>


                <main class="admin-profile-main">

                    <div class="admin-profile-container">


                        <!-- EN-TÊTE DE PAGE -->

                        <div class="admin-profile-page-header">

                            <div>

                                <p class="admin-profile-eyebrow">
                                    ESPACE ADMINISTRATION
                                </p>

                                <h1>
                                    Mon profil
                                </h1>

                                <p class="admin-profile-page-subtitle">
                                    Consultez les informations de votre compte administrateur.
                                </p>

                            </div>

                            <div class="admin-profile-page-icon">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>

                        </div>


                        <!-- PROFIL -->

                        <section class="admin-profile-card">


                            <!-- HERO PROFIL -->

                            <div class="admin-profile-hero">

                                <div class="admin-profile-avatar" id="profileAvatar">
                                    -
                                </div>

                                <div class="admin-profile-identity">

                                    <p class="admin-profile-identity-label">
                                        ADMINISTRATEUR
                                    </p>

                                    <h2 id="adminNomComplet">
                                        Administrateur
                                    </h2>

                                    <div class="admin-profile-role">
                                        <i class="fa-solid fa-user-tag"></i>
                                        <span id="adminRole">-</span>
                                    </div>

                                </div>

                            </div>


                            <!-- INFORMATIONS -->

                            <div class="admin-profile-section-header">

                                <div class="admin-profile-section-icon">
                                    <i class="fa-solid fa-user"></i>
                                </div>

                                <div>

                                    <h3>
                                        Informations administrateur
                                    </h3>

                                    <p>
                                        Informations associées à votre compte.
                                    </p>

                                </div>

                            </div>


                            <div class="admin-profile-grid">


                                <!-- NOM -->

                                <div class="admin-profile-item">

                                    <div class="admin-profile-item-icon">
                                        <i class="fa-solid fa-id-card"></i>
                                    </div>

                                    <div class="admin-profile-item-content">

                                        <span class="admin-profile-label">
                                            Nom
                                        </span>

                                        <strong id="profil_nom">
                                            -
                                        </strong>

                                    </div>

                                </div>


                                <!-- PRÉNOM -->

                                <div class="admin-profile-item">

                                    <div class="admin-profile-item-icon">
                                        <i class="fa-solid fa-user"></i>
                                    </div>

                                    <div class="admin-profile-item-content">

                                        <span class="admin-profile-label">
                                            Prénom
                                        </span>

                                        <strong id="profil_prenom">
                                            -
                                        </strong>

                                    </div>

                                </div>


                                <!-- EMAIL -->

                                <div class="admin-profile-item">

                                    <div class="admin-profile-item-icon">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>

                                    <div class="admin-profile-item-content">

                                        <span class="admin-profile-label">
                                            Adresse e-mail
                                        </span>

                                        <strong id="profil_email">
                                            -
                                        </strong>

                                    </div>

                                </div>


                                <!-- TÉLÉPHONE -->

                                <div class="admin-profile-item">

                                    <div class="admin-profile-item-icon">
                                        <i class="fa-solid fa-phone"></i>
                                    </div>

                                    <div class="admin-profile-item-content">

                                        <span class="admin-profile-label">
                                            Téléphone
                                        </span>

                                        <strong id="profil_tel">
                                            -
                                        </strong>

                                    </div>

                                </div>


                                <!-- RÔLE -->

                                <div class="admin-profile-item">

                                    <div class="admin-profile-item-icon">
                                        <i class="fa-solid fa-shield-halved"></i>
                                    </div>

                                    <div class="admin-profile-item-content">

                                        <span class="admin-profile-label">
                                            Rôle
                                        </span>

                                        <strong id="profil_role">
                                            -
                                        </strong>

                                    </div>

                                </div>


                            </div>


                            <!-- SÉCURITÉ -->

                            <div class="admin-profile-security">

                                <div class="admin-profile-security-icon">
                                    <i class="fa-solid fa-shield-halved"></i>
                                </div>

                                <div>

                                    <strong>
                                        Compte administrateur sécurisé
                                    </strong>

                                    <span>
                                        Vos informations sont accessibles uniquement après authentification.
                                    </span>

                                </div>

                            </div>


                        </section>

                    </div>

                </main>

            </div>


            <?php include("footer.php") ?>

        </div>

    </div>


    <!-- SCROLL TOP -->

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- JAVASCRIPT -->

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../js/sb-admin-2.min.js"></script>


    <script type="module">

        import AdminController from "../Controllers/AdminController.js";

        document.addEventListener("DOMContentLoaded", () => {

            const token = AdminController.checkAuth();

            if (!token) {
                return;
            }

            AdminController.loadProfile();
            AdminController.initLogout();

        });

    </script>

</body>

</html>
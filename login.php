<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fc;
        }

        .login-card {
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .login-left {
            background: linear-gradient(135deg, #5e72e4, #a3bffa);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .login-left i {
            font-size: 6rem;
            margin-bottom: 1.5rem;
        }

        .login-left h2 {
            font-weight: 700;
            text-align: center;
        }

        .login-left p {
            text-align: center;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .login-right {
            background-color: #fff;
            padding: 3rem 2rem;
        }

        .btn-primary {
            background-color: #5e72e4;
            border-color: #5e72e4;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #324cdd;
            border-color: #324cdd;
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
        }
    </style>

</head>

<body class="bg-gradient-primary">


    <?php if (isset($_SESSION['password']) && $_SESSION['password'] == 1): ?>
        <script>
            Swal.fire(
                'Instructions envoyées par mail !',
                'Cliquez sur OK !',
                'success'
            )
        </script>
        <?php $_SESSION['password'] = 0; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['password']) && $_SESSION['password'] == 2): ?>
        <script>
            Swal.fire(
                'Mot de passe réinitialisé avec succès !',
                'Cliquez sur OK !',
                'success'
            )
        </script>
        <?php $_SESSION['password'] = 0; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['err']) && $_SESSION['err'] == 1): ?>
        <script>
            Swal.fire(
                'Utilisateur ou mot de passe incorrect.',
                'Cliquez sur OK !',
                'error'
            )
        </script>
        <?php $_SESSION['err'] = 0; ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['err']) && $_SESSION['err'] == 2): ?>
        <script>
            Swal.fire(
                'Champs requis non remplis.',
                'Cliquez sur OK !',
                'error'
            )
        </script>
        <?php $_SESSION['err'] = 0; ?>
    <?php endif; ?>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row w-100 justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="card login-card flex-row">

                    <!-- Left side with icon and text -->
                    <div class="col-md-5 login-left">
                        <i class="fas fa-bus"></i>
                        <h2>Bienvenue sur BITRAVEL</h2>
                        <p>Gestion simplifiée des voyages, clients et réservations. Connectez-vous pour continuer.</p>
                    </div>

                    <!-- Right side with form -->
                    <div class="col-md-7 login-right">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900">Connexion</h1>
                            <p class="text-gray-600">Entrez vos identifiants pour accéder à votre compte</p>
                        </div>
                        <form class="user" action="api/modules/connection.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user"
                                    id="username" placeholder="Nom d'utilisateur..." name="username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user"
                                    id="password" placeholder="Mot de passe" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">Se connecter</button>
                        </form>
                    </div>

                </div>
                <div class="text-center text-muted mt-3">
                    <small>&copy; <?= date('Y') ?> BITECH - Tous droits réservés</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
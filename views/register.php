<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des concours</title>
    <link rel="stylesheet" href="../pages/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <!-- ===== HEADER ===== -->

    <section class="register-page">

        <div class="register-container">
            <h1>Créer un compte</h1>

            <form class="register-form" id="registerForm">
                <div class="form-columns">
                    <!-- COLONNE GAUCHE -->
                    <div class="form-column">


                        <div class="form-group">
                            <label>Nom <span class="required">*</span></label>
                            <input type="text" name="nom" placeholder="Votre nom de famille" required>
                        </div>

                        <div class="form-group">
                            <label>Prénom(s) <span class="required">*</span></label>
                            <input type="text" name="prenom" placeholder="Vos prénoms" required>
                        </div>

                        <div class="form-group">
                            <label>Rôle <span class="required">*</span></label>
                            <select name="role" required>
                                <option value="">Sélectionnez un rôle</option>
                                <option value="GESTIONNAIRE">Gestionnaire</option>
                                <option value="SUPERADMIN">Super Admin</option>
                            </select>
                        </div>

                    </div>

                    <!-- COLONNE DROITE -->
                    <div class="form-column">
            

                        <div class="form-group">
                            <label>Téléphone <span class="required">*</span></label>
                            <input type="text" name="telephone" placeholder="+226 XX XX XX XX" required>
                        </div>

                        <div class="form-group">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" placeholder="exemple@gmail.com" required>
                        </div>

                        <div class="form-group">
                            <label>Mot de passe <span class="required">*</span></label>
                            <input type="password" name="mot_de_passe" placeholder="Votre mot de passe" required>
                        </div>

                    </div>
                </div>
                <p id="formMessage" class="form-message"></p>
                <!-- BOUTON -->
                <div class="register-actions">
                    <button type="submit" class="btn-primary">Créer mon compte</button>
                </div>
            </form>

        </div>

    </section>

    <!-- ===== FOOTER ===== -->
   
    <script type="module">
        import AdminController from "../controllers/AdminController.js";

        document.addEventListener("DOMContentLoaded", () => {
            AdminController.initRegister();
        });
    </script>

</body>

</html>
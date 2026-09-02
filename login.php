<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - E-Concours</title>
    <link rel="stylesheet" href="pages/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>


    <section class="login-page">
        <div class="login-container">

            <div class="login-header">
                <i class="fas fa-user-circle"></i>
                <h1>Connexion à mon profil</h1>
                <p>Accédez à votre espace personnel</p>
            </div>

            <form class="login-form" id="loginForm">

                <!-- Email -->
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="votre@email.com" name="email" required>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="form-group">
                    <label>Mot de passe</label>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" placeholder="••••••••" name="mot_de_passe" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                    </div>
                </div>

                <p id="formError" class="form-error"></p>

                <!-- Bouton -->
                <button type="submit" class="btn-primary">Se connecter</button>
                <p id="formError" class="form-error"></p>

            </form>
        </div>
    </section>

<script type="module">
    import AdminController from "./Controllers/AdminController.js";

    document.addEventListener("DOMContentLoaded", () => {

        const form = document.getElementById("loginForm");

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const email = form.email.value;
            const password = form.mot_de_passe.value;

            await AdminController.login(email, password);

        });

    });
</script>

</body>

</html>
<!-- Modal -->
    <div class="modal fade" id="modalProfil" tabindex="-1" role="dialog" aria-labelledby="modalProfilLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="../api/modules/modifier_profil.php" method="POST" class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="modalProfilLabel">Modifier le profil</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id"
                        value="<?= isset($profil['id']) ? htmlspecialchars($profil['id']) : '' ?>">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="nom">Nom</label>
                                <input type="text" class="form-control" name="nom" id="nom"
                                    value="<?= htmlspecialchars($profil['nom']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label for="prenom">Prénom</label>
                                <input type="text" class="form-control" name="prenom" id="prenom"
                                    value="<?= htmlspecialchars($profil['prenom']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?= htmlspecialchars($profil['email']) ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="adresse">Adresse</label>
                                <input type="text" class="form-control" name="adresse" id="adresse"
                                    value="<?= htmlspecialchars($profil['adresse']) ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="username">Nom d'utilisateur</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    value="<?= htmlspecialchars($profil['username']) ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="type_compte">Type de compte</label>
                                <input type="text" class="form-control" name="type_compte" id="type_compte"
                                    value="<?= htmlspecialchars($profil['type_compte']) ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-warning">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de modification du mot de passe -->
    <div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="modalPasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="../api/modules/modifier_mot_de_passe.php">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPasswordLabel">Modifier le mot de passe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="ancien_mot_de_passe">Ancien mot de passe</label>
                            <input type="password" name="ancien_mot_de_passe" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="nouveau_mot_de_passe">Nouveau mot de passe</label>
                            <input type="password" name="nouveau_mot_de_passe" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="confirmation_mot_de_passe">Confirmer le mot de passe</label>
                            <input type="password" name="confirmation_mot_de_passe" class="form-control" required>
                        </div>
                        <!-- Optionnel : ID utilisateur caché -->
                       <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($id_user); ?>"> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <?php include("inclusions_bas.php") ?>
    <?php if (isset($_SESSION['profil_modifie']) && $_SESSION['profil_modifie']): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Profil mis à jour',
                text: 'Vos informations ont été enregistrées avec succès.',
                confirmButtonColor: '#28a745',
                confirmButtonText: 'OK'
            });
        </script>
        <?php unset($_SESSION['profil_modifie']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['mdp_err'])) { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '<?php echo $_SESSION["mdp_err"]; ?>',
                confirmButtonColor: '#dc3545'
            });
        </script>
        <?php unset($_SESSION['mdp_err']);
    } ?>

    <?php if (isset($_SESSION['mdp_success'])) { ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '<?php echo $_SESSION["mdp_success"]; ?>',
                confirmButtonColor: '#28a745'
            });
        </script>
        <?php unset($_SESSION['mdp_success']);
    } ?>


</body>

</html>
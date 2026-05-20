<div class="modal fade" id="ajouter_voyage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau voyage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_voyage.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">


                            <div class="col-md-4">
                                <label for="id_trajet">Trajet</label>

                                <select id="id_trajet" class="demo-default" name="id_trajet"
                                    placeholder="Select un trajet...">
                                    <option value="">Selectionnez un trajet...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_trajet, ville_depart, ville_arrivee, heure_depart FROM trajet where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo "<option value='{$row['id_trajet']}'>{$row['ville_depart']} → {$row['ville_arrivee']} ({$row['heure_depart']})</option>";
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="id_car">Car</label>

                                <select id="id_car" class="demo-default" name="id_car" placeholder="Select un car...">
                                    <option value="">Selectionnez un car...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_car, immatriculation FROM car where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<option value="' . $row['id_car'] . '">' . $row['immatriculation'] . '</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="id_chauffeur">Chauffeur</label>

                                <select id="id_chauffeur" class="demo-default" name="id_chauffeur"
                                    placeholder="Select un chauffeur...">
                                    <option value="">Selectionnez un chauffeur...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_chauffeur, nom_chauffeur, prenom, telephone FROM chauffeur where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<option value="' . $row['id_chauffeur'] . '">' . $row['nom_chauffeur'] . ' ' . $row['prenom'] . ' (' . $row['telephone'] . ')</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="date_depart">Date de départ (*)</label>
                                <input id="date_depart" class="form-control" type="date" name="date_depart" required>
                            </div>

                            <div class="col-md-4">
                                <label for="heure_depart">Heure de départ (*)</label>
                                <input id="heure_depart" class="form-control" type="time" name="heure_depart" required>
                            </div>

                            <div class="col-md-4">
                                <label for="statut">Statut (*)</label>
                                <select id="statut" class="form-control" name="statut" required>
                                    <option value="">Selectionnez un statut...</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Annulé">Annulé</option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="commentaire">Commentaire (*)</label>
                                <textarea id="commentaire" class="form-control" name="commentaire"
                                    placeholder="Entrer un commentaire" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        // Quand on sélectionne un trajet
        $('#id_trajet').on('change', function () {
            const id_trajet = $(this).val();

            if (!id_trajet) {
                $('#heure_depart').val(''); // réinitialise si aucun trajet
                return;
            }

            // Requête AJAX pour récupérer l'heure de départ du trajet
            $.ajax({
                url: '../api/modules/get_heure_trajet.php',
                type: 'GET',
                data: { id_trajet: id_trajet },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#heure_depart').val(response.heure_depart);
                    } else {
                        Swal.fire('Erreur', response.message, 'error');
                        $('#heure_depart').val('');
                    }
                },
                error: function () {
                    Swal.fire('Erreur', 'Impossible de récupérer l\'heure du trajet.', 'error');
                }
            });
        });

    });

</script>

<div class="modal fade" id="modifier_voyage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un voyage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_voyage.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_voyage" type="hidden" class="form-control" name="id_voyage">

                        <div class="row">


                            <div class="col-md-4">
                                <label for="id_trajet_modif">Trajet</label>

                                <select id="id_trajet_modif" class="demo-default" name="id_trajet"
                                    placeholder="Select un trajet...">
                                    <option value="">Selectionnez un trajet...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_trajet, ville_depart, ville_arrivee, heure_depart FROM trajet where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo "<option value='{$row['id_trajet']}'>{$row['ville_depart']} → {$row['ville_arrivee']} ({$row['heure_depart']})</option>";
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="id_car_modif">Car</label>

                                <select id="id_car_modif" class="demo-default" name="id_car"
                                    placeholder="Select un car...">
                                    <option value="">Selectionnez un car...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_car, immatriculation FROM car where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<option value="' . $row['id_car'] . '">' . $row['immatriculation'] . '</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="id_chauffeur_modif">Chauffeur</label>

                                <select id="id_chauffeur_modif" class="demo-default" name="id_chauffeur"
                                    placeholder="Select un chauffeur...">
                                    <option value="">Selectionnez un chauffeur...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_chauffeur, nom_chauffeur, prenom, telephone FROM chauffeur where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<option value="' . $row['id_chauffeur'] . '">' . $row['nom_chauffeur'] . ' ' . $row['prenom'] . ' (' . $row['telephone'] . ')</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="date_depart_modif">Date de départ (*)</label>
                                <input id="date_depart_modif" class="form-control" type="date" name="date_depart"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="heure_depart_modif">Heure de départ (*)</label>
                                <input id="heure_depart_modif" class="form-control" type="time" name="heure_depart"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="statut_modif">Statut (*)</label>
                                <select id="statut_modif" class="form-control" name="statut" required>
                                    <option value="">Selectionnez un statut...</option>
                                    <option value="En cours">En cours</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Annulé">Annulé</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="commentaire_modif">Commentaire (*)</label>
                                    <input id="commentaire_modif" class="form-control" type="text" name="commentaire"
                                        placeholder="Entrer le commentaire" required>
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
</div>
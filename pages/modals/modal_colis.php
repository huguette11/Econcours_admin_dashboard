<div class="modal fade" id="ajouter_colis" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un colis</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form_ajouter_colis" method="POST" action="../api/modules/ajouter_colis.php">
                <div class="modal-body">
                    <input type="hidden" id="id_client_colis" name="id_client">
                    <input type="hidden" id="id_voyage_ajout" name="id_voyage">

                    <div class="form-row mb-3">
                        <div class="col-md-4">
                            <label for="reference_ajout">Référence (*)</label>
                            <input type="text" class="form-control" id="reference_ajout" name="reference" required>
                        </div>
                        <div class="col-md-4">
                            <label for="contenu_ajout">Contenu (*)</label>
                            <input type="text" class="form-control" id="contenu_ajout" name="contenu" required>
                        </div>
                        <div class="col-md-4">
                            <label for="poids_ajout">Poids (*)</label>
                            <input type="text" class="form-control" id="poids_ajout" name="poids" required>
                        </div>
                    </div>

                    <div class="form-row mb-3">

                        <div class="col-md-4">
                            <label for="num_cnib_colis" class="form-label">Num CNIB</label>
                            <input type="text" id="num_cnib_colis" name="num_cnib" class="form-control" placeholder="Numéro CNIB">
                        </div>

                        <div class="col-md-4">
                            <label for="nom_colis" class="form-label">Nom</label>
                            <input type="text" id="nom_colis" name="nom" class="form-control" placeholder="Nom">
                        </div>

                        <div class="col-md-4">
                            <label for="prenom_colis" class="form-label">Prénom</label>
                            <input type="text" id="prenom_colis" name="prenom" class="form-control" placeholder="Prénom">
                        </div>


                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-4">
                            <label for="destinataire_ajout">Destinataire (*)</label>
                            <input type="text" class="form-control" id="destinataire_ajout" name="destinataire" required>
                        </div>

                        <div class="col-md-4">
                            <label for="tel_destinataire_ajout">Téléphone (*)</label>
                            <input type="text" class="form-control" id="tel_destinataire_ajout" name="tel_destinataire" required>
                        </div>

                        <div class="col-md-4">
                            <label for="id_trajet_ajout">Voyage</label>
                            <select id="id_trajet_ajout" class="demo-default" placeholder="Sélectionnez un voyage...">
                                <option value="">Sélectionnez un voyage...</option>
                                <?php
                                include('./../api/modules/connect_db.php');
                                $res = mysqli_query($db, "SELECT id_trajet, ville_depart, ville_arrivee, heure_depart FROM trajet WHERE suppression='Non'");
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<option value='{$row['id_trajet']}'>{$row['ville_depart']} → {$row['ville_arrivee']} ({$row['heure_depart']})</option>";
                                }
                                mysqli_close($db);
                                ?>
                            </select>
                        </div>

                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-4">
                            <label>Date de départ</label>
                            <input type="text" id="date_depart_ajout" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label>Immatriculation</label>
                            <input type="text" id="immatriculation_ajout" class="form-control" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="frais_expedition_ajout">Frais d'expédition (*)</label>
                            <input type="text" class="form-control" id="frais_expedition_ajout" name="frais_expedition" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // --- Initialisation du Selectize du champ Trajet ---
        if ($('#id_trajet_ajout').length) {
            $('#id_trajet_ajout').selectize({
                placeholder: 'Sélectionner un trajet...',
                allowEmptyOption: true,
                create: false,
            });
        }

        // --- Rafraîchir Selectize quand le modal s'ouvre ---
        $('#ajouter_colis').on('shown.bs.modal', function() {
            var selectizeInstance = $('#id_trajet_ajout')[0].selectize;
            if (selectizeInstance) selectizeInstance.refreshOptions(false);
        });

        // --- Quand on change le trajet, récupérer le voyage ---
        $('#id_trajet_ajout').on('change', function() {
            var id_trajet = $(this).val();
            if (!id_trajet) return;

            $.ajax({
                url: '../api/modules/get_voyage_by_trajet.php',
                type: 'GET',
                data: {
                    id_trajet: id_trajet
                },
                dataType: 'json',
                success: function(res) {
                    $('#date_depart_ajout').val(res.date_depart);
                    $('#immatriculation_ajout').val(res.immatriculation);
                    $('#id_voyage_ajout').val(res.id_voyage);
                },
                error: function() {
                    $('#date_depart_ajout').val('');
                    $('#immatriculation_ajout').val('');
                    $('#id_voyage_ajout').val('');
                    console.error('Erreur lors du chargement du voyage.');
                }
            });
        });

        // --- Vérifier CNIB et remplir nom/prénom ---
        $('#num_cnib_colis').on('input', function() {
            const num_cnib = $(this).val().trim();

            if (num_cnib.length < 3) {
                $('#nom_colis').val('').prop('readonly', false);
                $('#prenom_colis').val('').prop('readonly', false);
                $('#id_client_colis').val('');
                return;
            }

            $.ajax({
                url: '../api/modules/get_client_by_cnib.php',
                type: 'GET',
                data: {
                    num_cnib
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success && response.id_client) {
                        $('#nom_colis').val(response.nom).prop('readonly', true);
                        $('#prenom_colis').val(response.prenom).prop('readonly', true);
                        $('#id_client_colis').val(response.id_client);

                        Swal.fire({
                            icon: 'info',
                            title: 'Client trouvé',
                            text: `${response.nom} ${response.prenom}`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        $('#nom_colis').val('').prop('readonly', false);
                        $('#prenom_colis').val('').prop('readonly', false);
                        $('#id_client_colis').val('');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Client inconnu',
                            text: 'Veuillez saisir le nom et le prénom manuellement.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function() {
                    $('#nom_colis').val('').prop('readonly', false);
                    $('#prenom_colis').val('').prop('readonly', false);
                    $('#id_client_colis').val('');
                }
            });
        });
    });
</script>

<div class="modal fade" id="modifier_colis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un voyage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_colis.php" method="POST">
                <div class="modal-body">
                    <input id="id_colis" type="hidden" class="form-control" name="id_colis">
                    <input type="hidden" id="id_voyage_modif" name="id_voyage"> <!-- ✅ champ unique et correct -->



                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="reference_modif">Réferences du colis (*)</label>
                                <input id="reference_modif" class="form-control" type="text" name="reference" required>
                            </div>

                            <div class="col-md-4">
                                <label for="contenu_modif">Contenu (*)</label>
                                <input id="contenu_modif" class="form-control" type="text" name="contenu" required>
                            </div>

                            <div class="col-md-4">
                                <label for="poids_modif">Poids (*)</label>
                                <input id="poids_modif" class="form-control" type="text" name="poids" required>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="num_cnib_modif" class="form-label">Num CNIB</label>
                                <input type="text" id="num_cnib_modif" name="num_cnib" class="form-control" placeholder="Numéro CNIB">
                            </div>

                            <div class="col-md-4">
                                <label for="nom_modif" class="form-label">Nom</label>
                                <input type="text" id="nom_modif" name="nom" class="form-control" placeholder="Nom">
                            </div>

                            <div class="col-md-4">
                                <label for="prenom_modif" class="form-label">Prénom</label>
                                <input type="text" id="prenom_modif" name="prenom" class="form-control" placeholder="Prénom">
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="destinataire_modif">Destinataire (*)</label>
                                <input id="destinataire_modif" class="form-control" type="text" name="destinataire" required>
                            </div>

                            <div class="col-md-4">
                                <label for="tel_destinataire_modif">Téléphone du destinataire (*)</label>
                                <input id="tel_destinataire_modif" class="form-control" type="text" name="tel_destinataire" required>
                            </div>

                            <div class="col-md-4">
                                <label for="id_trajet_modif">Voyage</label>
                                <select id="id_trajet_modif" class="demo-default" placeholder="Sélectionnez un voyage...">
                                    <option value="">Sélectionnez un voyage...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $res = mysqli_query($db, "SELECT id_trajet, ville_depart, ville_arrivee, heure_depart FROM trajet WHERE suppression='Non'");
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        echo "<option value='{$row['id_trajet']}'>{$row['ville_depart']} → {$row['ville_arrivee']} ({$row['heure_depart']})</option>";
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
                                <label>Date de départ</label>
                                <input type="text" id="date_depart_modif" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label>Immatriculation</label>
                                <input type="text" id="immatriculation_modif" class="form-control" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="frais_expedition_modif">Frais d'expédition (*)</label>
                                <input id="frais_expedition_modif" class="form-control" type="text" name="frais_expedition" required>
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
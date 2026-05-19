<div class="modal fade" id="ajouter_reservation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'une nouvelle réservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_reservation.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="num_place" name="num_place">
                        <!-- <input type="hidden" id="id_client" name="id_client"> -->

                        <div class="row">

                            <div class="col-md-4">
                                <label for="date_voyage">Date du voyage (*)</label>
                                <input id="date_voyage" class="form-control" type="date" name="date_voyage" required>
                            </div>

                            <div class="col-md-4">
                                <label for="id_voyage">Voyage (*)</label>
                                <select id="id_voyage" class="form-control" name="id_voyage" required>
                                    <option value="">Sélectionnez d'abord une date...</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="num_cnib">Numéro CNIB</label>
                                <input type="text" id="num_cnib" name="num_cnib" class="form-control"
                                    placeholder="Ex: B123456789" required>
                            </div>
                        </div>

                    </div>



                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" class="form-control" placeholder="Nom du client"
                                    readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="prenom">Prénom</label>
                                <input type="text" id="prenom" name="prenom" class="form-control"
                                    placeholder="Prénom du client" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="date_reservation">Date de réservation (*)</label>
                                <input id="date_reservation" class="form-control" type="date" name="date_reservation"
                                    required>

                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="montant">Montant (*)</label>
                                <input id="montant" class="form-control" type="number" name="montant" required readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="mode_paiement">Mode de paiement (*)</label>
                                <select name="mode_paiement" id="mode_paiement" class="form-control" required>
                                    <option value="">Sélectionnez un mode de paiement...</option>
                                    <option value="Carte de crédit">Carte de crédit</option>
                                    <option value="Mobile money">Mobile money</option>
                                    <option value="Espèce">Espèce</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="date_paiement">Date de paiement (*)</label>
                                <input id="date_paiement" class="form-control" type="date" name="date_paiement"
                                    required>
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
    $(document).ready(function() {

        // --- 🔹 Remplir automatiquement la date du jour dans les champs date ---
        const today = new Date();
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');
        const todayStr = `${yyyy}-${mm}-${dd}`;

        if ($('#date_reservation').length) $('#date_reservation').val(todayStr);
        if ($('#date_paiement').length) $('#date_paiement').val(todayStr);

        // --- 🔹 Recherche automatique du client via CNIB ---
        $('#num_cnib').on('blur', function() {
            const cnib = $(this).val().trim();
            if (cnib === '') return;

            $.ajax({
                url: '../api/modules/get_client_by_cnib.php',
                type: 'GET',
                data: {
                    num_cnib: cnib
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Client trouvé
                        $('#nom').val(response.nom).prop('readonly', true);
                        $('#prenom').val(response.prenom).prop('readonly', true);
                        $('#id_client').val(response.id_client);
                    } else {
                        // Client non trouvé
                        Swal.fire({
                            icon: 'info',
                            title: 'Nouveau client',
                            text: 'Aucun client trouvé avec ce numéro CNIB. Vous pouvez saisir son nom et prénom.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                        $('#nom').val('').prop('readonly', false);
                        $('#prenom').val('').prop('readonly', false);
                        $('#id_client').val('');
                    }
                },
                error: function() {
                    Swal.fire('Erreur', 'Impossible de vérifier la CNIB', 'error');
                }
            });
        });

        // --- 🔹 Initialisation des Selectize ---
        if ($('#id_client').length) {
            $('#id_client').selectize({
                sortField: 'text'
            });
        }

        if ($('#id_voyage').length) {
            $('#id_voyage').selectize({
                sortField: 'text'
            });
        }

        const voyageSelect = $('#id_voyage')[0]?.selectize;

        // --- 🔹 Lorsqu'on change la date du voyage ---
        $('#date_voyage').on('change', function() {
            const date_voyage = $(this).val();
            if (!voyageSelect) return;

            voyageSelect.clearOptions();
            voyageSelect.setValue('');

            if (!date_voyage) {
                voyageSelect.addOption({
                    value: '',
                    text: 'Sélectionnez d’abord une date...'
                });
                return;
            }

            // Charger les voyages disponibles
            $.ajax({
                url: '../api/modules/get_voyages_par_date.php',
                type: 'GET',
                data: {
                    date_voyage
                },
                dataType: 'json',
                success: function(response) {
                    voyageSelect.clearOptions();
                    voyageSelect.setValue('');

                    if (!response || response.length === 0) {
                        voyageSelect.addOption({
                            value: '',
                            text: 'Aucun voyage disponible pour cette date'
                        });
                        return;
                    }

                    // Ajouter les voyages reçus
                    response.forEach(v => {
                        voyageSelect.addOption({
                            value: v.id_voyage,
                            text: v.trajet, // ex: Ouagadougou - Koudougou (14:00)
                            prix: v.prix,
                            capacite: v.capacite,
                            places_reservees: v.places_reservees
                        });
                    });
                },
                error: function() {
                    Swal.fire('Erreur', 'Impossible de charger les voyages pour cette date.', 'error');
                }
            });
        });

        // --- 🔹 Lorsqu'on choisit un voyage ---
        $('#id_voyage').on('change', function() {
            if (!voyageSelect) return;

            const selectedValue = voyageSelect.getValue();
            const selectedOption = voyageSelect.options[selectedValue];

            if (!selectedOption) {
                $('#montant').val('');
                $('#num_place').val('');
                return;
            }

            const prix = parseFloat(selectedOption.prix);
            const capacite = parseInt(selectedOption.capacite, 10);
            const reservees = parseInt(selectedOption.places_reservees, 10);

            if (isNaN(capacite) || isNaN(reservees)) {
                Swal.fire('Erreur', 'Les informations de capacité ne sont pas valides.', 'error');
                return;
            }

            // Vérifier si le voyage est complet
            if (reservees >= capacite) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Voyage complet',
                    text: 'Toutes les places pour ce voyage sont déjà réservées.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    voyageSelect.setValue('');
                    $('#montant').val('');
                    $('#num_place').val('');
                });
                return;
            }

            // Afficher le prix
            $('#montant').val(prix);

            // Charger automatiquement la prochaine place libre
            $.ajax({
                url: '../api/modules/get_prochaine_place.php',
                type: 'GET',
                data: {
                    id_voyage: selectedValue
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#num_place').val(response.prochaine_place);
                    } else {
                        Swal.fire('Erreur', response.message, 'error');
                        $('#num_place').val('');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erreur AJAX:', error);
                }
            });
        });

    });
</script>




<div class="modal fade" id="modifier_reservation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'une réservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_reservation.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_reservation" type="hidden" class="form-control" name="id_reservation">
                        <input type="hidden" id="id_client_modif" class="form-control" name="id_client">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="date_voyage_modif">Date du voyage</label>
                                <input id="date_voyage_modif" class="form-control" type="date" name="date_voyage"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label for="id_voyage_modif">Voyage</label>
                                <select id="id_voyage_modif" class="form-control" name="id_voyage" required>
                                    <option value="">Sélectionnez d'abord une date...</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="num_cnib_modif" class="form-label">Numéro CNIB</label>
                                <input type="text" class="form-control" id="num_cnib_modif" name="num_cnib"
                                    placeholder="Saisir le CNIB" required>
                            </div>
                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="nom_modif" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom_modif" name="nom" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="prenom_modif" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="prenom_modif" name="prenom" readonly>
                            </div>

                            <div class="col-md-4">
                                <label for="num_place_modif">Numéro de place (*)</label>
                                <input id="num_place_modif" name="num_place" class="form-control" readonly></input>

                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="date_reservation_modif">Date de réservation (*)</label>
                                <input id="date_reservation_modif" class="form-control" type="date"
                                    name="date_reservation" required>

                            </div>

                            <div class="col-md-4">
                                <label for="montant_modif">Montant (*)</label>
                                <input id="montant_modif" class="form-control" type="number" name="montant" required>
                            </div>

                            <div class="col-md-4">
                                <label for="mode_paiement_modif">Mode de paiement (*)</label>
                                <select id="mode_paiement_modif" class="form-control" name="mode_paiement" required>
                                    <option value="">Sélectionnez un mode de paiement...</option>
                                    <option value="Carte de crédit">Carte de crédit</option>
                                    <option value="Mobile money">Mobile money</option>
                                    <option value="Espèce">Espèce</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="date_paiement_modif">Date de paiement (*)</label>
                                <input id="date_paiement_modif" class="form-control" type="date" name="date_paiement"
                                    required>
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
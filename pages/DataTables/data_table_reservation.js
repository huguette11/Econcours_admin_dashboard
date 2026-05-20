$(document).ready(function () {
    var tab = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/reservation_data.php',
            type: 'POST', // Utilisez la méthode POST
        },
        dom: 'lBfrtip',
        buttons: [
            'copy', 'excel', 'csv', 'pdf'
        ],
        columnDefs: [

            {
                targets: [0],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },
            {
                targets: [1],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [2],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [3],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [4],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [5],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [6],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [7],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [8],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },


            {
                targets: [9],
                data: null,
                defaultContent: '<span  title="Modifier la réservation"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Reservation btn btn-warning" href="#modifier_reservation" ><i class="fa  fa-pencil "></i></button></span>',
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                },
                orderable: false
            },
            {
                targets: [10],
                data: null,
                defaultContent: '<span  title="Supprimer le voyage"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                },
                orderable: false
            },

            // {
            //     targets: [10],
            //     data: null,
            //     render: function (data, type, row) {
            //         return `
            //             <button 
            //                 class="btn btn-success btn-sm btn-imprimer" 
            //                 title="Télécharger le ticket"
            //                 data-id-reservation="${row[11]}">
            //                 <i class="fa-solid fa-file-export"></i>
            //             </button>
            //         `;
            //     },
            //     orderable: false
            // },

            {
                targets: [11],
                data: null,
                render: function (data, type, row) {
                    return `
                       <button class="btn btn-sm btn-success btn-exporter">
                       <i class="fa-solid fa-file-export"></i>
                       </button>

                    `;
                },
                orderable: false
            },

            {
                targets: [12, 13, 14],
                visible: false,
                searchable: false
            }
        ],
        order: [],
        "deferRender": true,

        "pageLength": 5,
        "lengthMenu": [[1, 2, 3, 4, 5, 10, 25, 50, 100, 200, -1], [1, 2, 3, 4, 5, 10, 25, 50, 100, 200, "Tout"]],

        "language": {
            "sProcessing": "Traitement en cours...",
            "sSearch": "Rechercher&nbsp;:",
            "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix": "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst": "Premier",
                "sPrevious": "Pr&eacute;c&eacute;dent",
                "sNext": "Suivant",
                "sLast": "Dernier"
            },
            "oAria": {
                "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
            }
        }
    });
    // function unEscape(htmlStr) {
    //     if (htmlStr) {
    //         htmlStr = htmlStr.replace(/&lt;/g, "<");
    //         htmlStr = htmlStr.replace(/&gt;/g, ">");
    //         htmlStr = htmlStr.replace(/&quot;/g, "\"");
    //         htmlStr = htmlStr.replace(/&#039;/g, "\'");
    //         htmlStr = htmlStr.replace(/&amp;/g, "&");
    //         htmlStr = htmlStr.replace(/<br>/g, "\n");
    //         return htmlStr;
    //     }
    // };
    function unEscape(htmlStr) {
        if (htmlStr === null || htmlStr === undefined) return "";
        return String(htmlStr) // transforme tout en string, même les nombres
            .replace(/&lt;/g, "<")
            .replace(/&gt;/g, ">")
            .replace(/&quot;/g, "\"")
            .replace(/&#039;/g, "'")
            .replace(/&amp;/g, "&")
            .replace(/<br>/g, "\n");
    }
    $(document).ready(function () {

        // --- Ouvrir le modal de modification ---
        $('#dataTable tbody').on('click', '#modifier', function () {
            const data = tab.row($(this).parents('tr')).data();

            const id = data[12];
            const id_voyage = data[13];
            const id_client = data[14];
            const num_place = unEscape(data[3]);
            const date_reservation = unEscape(data[4]);
            const date_voyage = unEscape(data[5]);
            const montant = unEscape(data[6]);
            const mode_paiement = unEscape(data[7]);
            const date_paiement = unEscape(data[8]);

            // Remplir les champs fixes
            $('#id_reservation').val(id);
            $('#date_reservation_modif').val(date_reservation);
            $('#date_voyage_modif').val(date_voyage);
            $('#mode_paiement_modif').val(mode_paiement);
            $('#date_paiement_modif').val(date_paiement);
            $('#montant_modif').val(montant);

            // Désactiver le champ numéro de place par défaut
            $('#num_place_modif').val(num_place).prop('readonly', true);

            // Charger les voyages pour la date actuelle
            chargerVoyagesParDate(date_voyage, id_voyage, num_place, montant);

            // Charger les infos client via l'ID client
            chargerInfosClient(id_client);

            // Afficher le modal
            $('#modifier_reservation').modal('show');
        });


        // --- Quand on change la date ---
        $('#date_voyage_modif').on('change', function () {
            const date = $(this).val();
            $('#id_voyage_modif').val('').trigger('change');
            $('#montant_modif').val('');
            $('#num_place_modif').val('').prop('readonly', true);

            if (date) {
                chargerVoyagesParDate(date);
            }
        });


        // --- Quand on change le voyage ---
        $('#id_voyage_modif').on('change', function () {
            const selectedOption = $(this).find(':selected');
            const prix = parseFloat(selectedOption.data('prix'));
            const capacite = parseInt(selectedOption.data('capacite'), 10);
            const places = parseInt(selectedOption.data('places'), 10);

            if (!selectedOption.val()) {
                $('#montant_modif').val('');
                $('#num_place_modif').val('').prop('readonly', true);
                return;
            }

            // Remplir le montant automatiquement
            $('#montant_modif').val(prix);

            // Charger automatiquement la prochaine place libre
            const id_voyage = selectedOption.val();
            $.ajax({
                url: '../api/modules/get_prochaine_place.php',
                type: 'GET',
                data: { id_voyage },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#num_place_modif').val(response.prochaine_place).prop('readonly', true);
                    } else {
                        Swal.fire('Erreur', response.message, 'error');
                        $('#num_place_modif').val('').prop('readonly', true);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur AJAX (modif):', error);
                    $('#num_place_modif').val('').prop('readonly', true);
                }
            });
        });


        // === Quand on change le CNIB ===
        $('#num_cnib_modif').on('input', function () {
            const num_cnib = $(this).val().trim();

            // Si trop court, on réinitialise les champs
            if (num_cnib.length < 3) {
                $('#nom_modif').val('').prop('readonly', false);
                $('#prenom_modif').val('').prop('readonly', false);
                return;
            }

            $.ajax({
                url: '../api/modules/get_client_by_cnib.php',
                type: 'GET',
                data: { num_cnib },
                dataType: 'json',
                success: function (response) {
                    console.log('Réponse CNIB:', response);

                    if (response.success && response.id_client) {
                        $('#nom_modif').val(response.nom).prop('readonly', true);
                        $('#prenom_modif').val(response.prenom).prop('readonly', true);
                        $('#id_client_modif').val(response.id_client);

                        Swal.fire({
                            icon: 'info',
                            title: 'Client trouvé',
                            text: `${response.nom} ${response.prenom}`,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        $('#nom_modif').val('').prop('readonly', false);
                        $('#prenom_modif').val('').prop('readonly', false);
                        $('#id_client_modif').val('');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Client inconnu',
                            text: 'Veuillez saisir le nom et le prénom manuellement.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }

            });
        });


        // --- Fonction : charger voyages pour une date ---
        function chargerVoyagesParDate(date_voyage, voyage_selectionne = null, place_selectionnee = null, montant_selectionne = null) {
            const select = $('#id_voyage_modif');
            select.empty();

            if (!date_voyage) {
                select.append('<option value="">Sélectionnez une date de voyage</option>');
                $('#num_place_modif').val('').prop('readonly', true);
                $('#montant_modif').val('');
                return;
            }

            $.ajax({
                url: '../api/modules/get_voyages_par_date.php',
                type: 'GET',
                data: { date_voyage },
                dataType: 'json',
                success: function (response) {
                    select.empty();

                    if (!response || response.length === 0) {
                        select.append('<option value="">Aucun voyage disponible pour cette date</option>');
                        $('#num_place_modif').val('').prop('readonly', true);
                        $('#montant_modif').val('');
                        return;
                    }

                    select.append('<option value="">Sélectionnez un voyage...</option>');

                    response.forEach(v => {
                        const disabled = v.places_reservees >= v.capacite ? 'disabled' : '';
                        select.append(`
                        <option value="${v.id_voyage}"
                                data-prix="${v.prix}"
                                data-capacite="${v.capacite}"
                                data-places="${v.places_reservees}"
                                ${disabled}>
                            ${v.trajet} ${disabled ? '(Complet)' : ''}
                        </option>
                    `);
                    });

                    if (voyage_selectionne) {
                        select.val(voyage_selectionne).trigger('change');
                        if (montant_selectionne !== null) $('#montant_modif').val(montant_selectionne);
                        if (place_selectionnee !== null) $('#num_place_modif').val(place_selectionnee).prop('readonly', true);
                    }
                },
                error: function () {
                    Swal.fire('Erreur', 'Impossible de charger les voyages pour cette date.', 'error');
                }
            });
        }


        // --- Fonction : charger infos client ---
        function chargerInfosClient(id_client) {
            if (!id_client) return;

            $.ajax({
                url: '../api/modules/get_client_par_id.php',
                type: 'GET',
                data: { id_client },
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        $('#num_cnib_modif').val(response.data.num_cnib);
                        $('#nom_modif').val(response.data.nom).prop('readonly', true);
                        $('#prenom_modif').val(response.data.prenom).prop('readonly', true);
                        $('#id_client_modif').val(response.data.id_client);
                    } else {
                        $('#num_cnib_modif, #nom_modif, #prenom_modif').val('').prop('readonly', false);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erreur AJAX client :', error);
                    $('#num_cnib_modif, #nom_modif, #prenom_modif').val('').prop('readonly', false);
                }
            });
        }


        // --- Fonction utilitaire pour désencoder HTML ---
        function unEscape(htmlStr) {
            if (htmlStr === null || htmlStr === undefined) return "";
            return String(htmlStr)
                .replace(/&lt;/g, "<")
                .replace(/&gt;/g, ">")
                .replace(/&quot;/g, "\"")
                .replace(/&#039;/g, "'")
                .replace(/&amp;/g, "&")
                .replace(/<br>/g, "\n");
        }

    });


    //Supprimer utilisateur
    $('#dataTable tbody').on('click', '#supprimer', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id_reservation = data[12];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer la réservation ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer la réservation",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './../api/modules/supprimer_reservation.php?id_reservation=' + id_reservation;
            }
            else {

            }
        })


    });
    let selectizeAjoutTrajet;
    let selectizeAjoutClient;

    $(document).ready(function () {
        $('#id_trajet').selectize({ sortField: 'text' })
        $('#id_client').selectize({ sortField: 'text' })

    });

    $('#dataTable tbody').on('click', '.btn-exporter', function () {
        var data = tab.row($(this).parents('tr')).data();

        // Récupérer l'ID de la réservation
        var id_reservation = data[12]; // ⚠️ adapte l'index selon ta table

        // Redirection vers le script PHP qui génère le PDF
        window.location.href = "../api/modules/imprimer_ticket.php?id_reservation=" + id_reservation;
    });

});
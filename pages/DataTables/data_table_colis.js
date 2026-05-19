$(document).ready(function () {
    var tab = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/colis_data.php',
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
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [10],
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                }
            },

            {
                targets: [11],
                data: null,
                render: function (data, type, row) {
                    // row[statut_index] => remplace statut_index par l'indice de la colonne statut
                    const statutRaw = row[11]; // remplace statut_index par l'indice réel
                    const statut = statutRaw ? statutRaw.toString().toLowerCase() : '';

                    const couleur = (statut === 'récupéré') ? 'btn-success' : 'btn-info';
                    const texte = (statut === 'récupéré') ? 'Récupéré' : 'Enregistré';

                    return `<button type="button" class="btn btn-sm ${couleur} statut" data-id="${row[14]}">${texte}</button>`;
                },
                orderable: false
            },



            {
                targets: [12],
                data: null,
                defaultContent: '<span  title="Modifier le colis"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Colis btn btn-warning" href="#modifier_colis" ><i class="fa  fa-pencil "></i></button></span>',
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                },
                orderable: false
            },
            {
                targets: [13],
                data: null,
                defaultContent: '<span  title="Supprimer le colis"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',
                createdCell: function (td) {

                    $(td).css('text-align', 'center')

                },
                orderable: false
            },

            {
                targets: [14, 15, 16, 17, 18],
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

        $('#dataTable tbody').on('click', '.statut', function () {
            const btn = $(this);
            const id_colis = btn.data('id');

            $.post('../api/modules/changer_statut_colis.php', { id_colis }, function (response) {
                if (response.success) {
                    // inverser la couleur et le texte du bouton
                    if (btn.hasClass('btn-info')) {
                        btn.removeClass('btn-info').addClass('btn-success').text('Récupéré');
                    } else {
                        btn.removeClass('btn-success').addClass('btn-info').text('Enregistré');
                    }

                    Swal.fire('Succès', 'Le statut du colis a été mis à jour.', 'success');
                } else {
                    Swal.fire('Erreur', response.message || 'Impossible de changer le statut.', 'error');
                }
            }, 'json');
        });
    });


    $(document).ready(function () {
        // --- Initialisation Selectize pour le trajet ---
        $('#id_trajet_modif').selectize({});
        var trajetSelect = $('#id_trajet_modif')[0].selectize;

        // --- Ouvrir le modal de modification ---
        $('#dataTable tbody').on('click', '#modifier', function () {
            var data = tab.row($(this).parents('tr')).data();

            var id_colis = data[14];
            var id_client = data[15];
            var id_voyage = data[16];
            var id_car = data[17];
            var id_trajet = data[18];

            $('#id_colis').val(id_colis);
            $('#id_voyage_modif').val(id_voyage);

            $('#reference_modif').val(data[1]);
            $('#contenu_modif').val(data[2]);
            $('#poids_modif').val(data[3]);
            $('#destinataire_modif').val(data[5]);
            $('#tel_destinataire_modif').val(data[6]);
            $('#frais_expedition_modif').val(data[10]);

            trajetSelect.setValue(id_trajet);

            // remplir date_depart et immatriculation
            $('#date_depart_modif').val(data[8]);
            $('#immatriculation_modif').val(data[9]);

            // --- Charger infos client via id_client ---
            chargerInfosClient(id_client);

            $('#modifier_colis').modal('show');
        });

        // --- Changement de trajet ---
        $('#id_trajet_modif').on('change', function () {
            var id_trajet = $(this).val();
            if (!id_trajet) return;

            $.ajax({
                url: '../api/modules/get_voyage_by_trajet.php',
                type: 'GET',
                data: { id_trajet: id_trajet },
                dataType: 'json',
                success: function (res) {
                    $('#date_depart_modif').val(res.date_depart);
                    $('#immatriculation_modif').val(res.immatriculation);
                    $('#id_voyage_modif').val(res.id_voyage);
                }
            });
        });

        // --- Vérifier CNIB et remplir nom/prénom ---
        $('#num_cnib_modif').on('input', function () {
            const num_cnib = $(this).val().trim();

            if (num_cnib.length < 3) {
                $('#nom_modif').val('').prop('readonly', false);
                $('#prenom_modif').val('').prop('readonly', false);
                $('#id_client_modif_hidden').val('');
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
                        $('#id_client_modif_hidden').val(response.id_client);

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
                        $('#id_client_modif_hidden').val('');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Client inconnu',
                            text: 'Veuillez saisir le nom et le prénom manuellement.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function () {
                    console.error('Erreur lors de la vérification du CNIB.');
                    $('#nom_modif').val('').prop('readonly', false);
                    $('#prenom_modif').val('').prop('readonly', false);
                    $('#id_client_modif_hidden').val('');
                }
            });
        });

        // --- Charger infos client par ID ---
        function chargerInfosClient(id_client) {
            if (!id_client) return;

            $.ajax({
                url: '../api/modules/get_client_par_id.php',
                type: 'GET',
                data: { id_client },
                dataType: 'json',
                success: function (res) {
                    if (res.success && res.data) {
                        $('#num_cnib_modif').val(res.data.num_cnib);
                        $('#nom_modif').val(res.data.nom).prop('readonly', true);
                        $('#prenom_modif').val(res.data.prenom).prop('readonly', true);
                        $('#id_client_modif_hidden').val(res.data.id_client);
                    }
                },
                error: function () {
                    $('#num_cnib_modif').val('');
                    $('#nom_modif').val('').prop('readonly', false);
                    $('#prenom_modif').val('').prop('readonly', false);
                    $('#id_client_modif_hidden').val('');
                }
            });
        }
    });



    //Supprimer utilisateur
    $('#dataTable tbody').on('click', '#supprimer', function () {
        var data = tab.row($(this).parents('tr')).data();
        var id_colis = data[14];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer le voyage ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer le voyage",
            cancelButtonText: "Annuler"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = './../api/modules/supprimer_colis.php?id_colis=' + id_colis;
            }
            else {

            }
        })


    });

});
$(document).ready(function() {
    var tab=$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/voyage_data.php',
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
                data: null,
                defaultContent: '<span  title="Modifier le voyage"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Voyage btn btn-warning" href="#modifier_voyage" ><i class="fa  fa-pencil "></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false
            },
            {
                targets: [9],
                data: null,
                defaultContent: '<span  title="Supprimer le voyage"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false 
            },

            {
                targets: [10, 11, 12, 13],
                visible: false,
                searchable: false
            }
        ],
        order: [],
        "deferRender": true,
    
        "pageLength": 5,
        "lengthMenu": [ [1, 2, 3, 4, 5, 10, 25, 50, 100, 200, -1], [1, 2, 3, 4, 5, 10, 25, 50, 100, 200, "Tout"]],
        
        "language": {
            "sProcessing":     "Traitement en cours...",
            "sSearch":         "Rechercher&nbsp;:",
            "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
            "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
            "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
            "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
            "sInfoPostFix":    "",
            "sLoadingRecords": "Chargement en cours...",
            "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
            "oPaginate": {
                "sFirst":      "Premier",
                "sPrevious":   "Pr&eacute;c&eacute;dent",
                "sNext":       "Suivant",
                "sLast":       "Dernier"
            },
            "oAria": {
                "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
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


    $('#dataTable tbody').on('click', '#modifier', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id = data[10];
        var id_trajet = data[11];
        var id_car = data[12];
        var id_chauffeur = data[13];
        var date_depart = unEscape(data[4]);
        var heure_depart = unEscape(data[5]);
        var statut = unEscape(data[6]);
        var commentaire = unEscape(data[7]);
    
       
        $('#id_voyage').val(id);
        $('#id_trajet_modif').val(id_trajet);
        $('#id_car_modif').val(id_car);
        $('#id_chauffeur_modif').val(id_chauffeur);
        $('#date_depart_modif').val(date_depart);
        $('#heure_depart_modif').val(heure_depart);
        $('#statut_modif').val(statut);
        $('#commentaire_modif').val(commentaire);

        // ouvre modal et set selectize (tu peux garder ton setTimeout si nécessaire)
        $('#modifier_voyage').modal('show');
        setTimeout(() => {
            const $trajet = $('#id_trajet_modif');
            if ($trajet[0] && $trajet[0].selectize) {
                $trajet[0].selectize.setValue(id_trajet);
            } else if ($trajet[0]) {
                // init selectize si pas présent (ton code faisait destroy/recreate)
                $trajet.selectize && $trajet.selectize();
                try { $trajet[0].selectize.setValue(id_trajet); } catch (e) { }
            }

            const $car = $('#id_car_modif');
            if ($car[0] && $car[0].selectize) {
                $car[0].selectize.setValue(id_car);
            } else if ($car[0]) {
                // init selectize si pas présent (ton code faisait destroy/recreate)
                $car.selectize && $car.selectize();
                try { $car[0].selectize.setValue(id_car); } catch (e) { }
            }

            const $chauffeur = $('#id_chauffeur_modif');
            if ($chauffeur[0] && $chauffeur[0].selectize) {
                $chauffeur[0].selectize.setValue(id_chauffeur);
            } else if ($chauffeur[0]) {
                // init selectize si pas présent (ton code faisait destroy/recreate)
                $chauffeur.selectize && $chauffeur.selectize();
                try { $chauffeur[0].selectize.setValue(id_chauffeur); } catch (e) { }
            }
        }, 150);
        
    });

    //Supprimer utilisateur
    $('#dataTable tbody').on('click', '#supprimer', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id_voyage = data[10];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer le voyage ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer le voyage",
            cancelButtonText: "Annuler"
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    window.location.href= './../api/modules/supprimer_voyage.php?id_voyage=' + id_voyage;
                }
                else
                {

                }
            })
        

    });
    let selectizeAjoutTrajet;
    let selectizeAjoutCar;
    let selectizeAjoutChauffeur;

    $(document).ready(function () {
        $('#id_trajet').selectize({ sortField: 'text' })
        $('#id_car').selectize({ sortField: 'text' })
        $('#id_chauffeur').selectize({ sortField: 'text' })
    });
});
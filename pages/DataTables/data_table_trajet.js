$(document).ready(function() {
    var tab=$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/trajet_data.php',
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
                defaultContent: '<span  title="Modifier le trajet"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Trajet btn btn-warning" href="#modifier_trajet" ><i class="fa  fa-pencil "></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false
            },
            {
                targets: [9],
                data: null,
                defaultContent: '<span  title="Supprimer le trajet"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false 
            },
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
        var id_gare = data[11];
        var ville_depart = unEscape(data[2]);
        var ville_arrivee = unEscape(data[3]);
        var distance = unEscape(data[4]);
        var heure_depart = unEscape(data[5]);
        var heure_arrivee = unEscape(data[6]);
        var prix = unEscape(data[7]);

        $('#id_trajet').val(id);
        $('#id_gare_modif').val(id_gare);
        $('#ville_depart_modif').val(ville_depart);
        $('#ville_arrivee_modif').val(ville_arrivee);
        $('#distance_modif').val(distance);
        $('#heure_depart_modif').val(heure_depart);
        $('#heure_arrivee_modif').val(heure_arrivee);
        $('#prix_modif').val(prix);

        // ouvre modal et set selectize (tu peux garder ton setTimeout si nécessaire)
        $('#modifier_trajet').modal('show');
        setTimeout(() => {
            const $gare = $('#id_gare_modif');
            if ($gare[0] && $gare[0].selectize) {
                $gare[0].selectize.setValue(id_gare);
            } else if ($gare[0]) {
                // init selectize si pas présent (ton code faisait destroy/recreate)
                $gare.selectize && $gare.selectize();
                try { $gare[0].selectize.setValue(id_gare); } catch (e) { }
            }
        }, 150);
        
    });

    //Supprimer utilisateur
    $('#dataTable tbody').on('click', '#supprimer', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id_trajet = data[10];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer le trajet ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer le trajet",
            cancelButtonText: "Annuler"
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    window.location.href= './../api/modules/supprimer_trajet.php?id_trajet=' + id_trajet;
                }
                else
                {

                }
            })
        

    });
    let selectizeAjoutCar;

    $(document).ready(function () {
        $('#id_gare').selectize({ sortField: 'text' })
    });
});
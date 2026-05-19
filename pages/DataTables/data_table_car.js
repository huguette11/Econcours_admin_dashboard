$(document).ready(function() {
    var tab=$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/car_data.php',
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
                data: null,
                defaultContent: '<span  title="Modifier le car"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Car btn btn-warning" href="#modifier_car" ><i class="fa  fa-pencil "></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false
            },
            {
                targets: [7],
                data: null,
                defaultContent: '<span  title="Supprimer le car"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',    
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

        var id = data[8];
        var id_gare = data[9];
        var immatriculation = unEscape(data[2]);
        var modele = unEscape(data[3]);
        var capacite = unEscape(data[4]);
        var etat = unEscape(data[5]);

        $('#id_car').val(id);
        $('#id_gare_modif').val(id_gare);
        $('#immatriculation_modif').val(immatriculation);
        $('#modele_modif').val(modele);
        $('#capacite_modif').val(capacite);
        $('#etat_modif').val(etat);

        // ouvre modal et set selectize (tu peux garder ton setTimeout si nécessaire)
        $('#modifier_car').modal('show');
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

        var id_car = data[8];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer le car ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer le car",
            cancelButtonText: "Annuler"
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    window.location.href= './../api/modules/supprimer_car.php?id_car=' + id_car;
                
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
$(document).ready(function() {
    var tab=$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/gare_data.php',
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
                data: null,
                defaultContent: '<span  title="Modifier la gare"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_gare btn btn-warning" href="#modifier_gare" ><i class="fa  fa-pencil "></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false
            },
            {
                targets: [6],
                data: null,
                defaultContent: '<span  title="Supprimer la gare"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',    
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
    function unEscape(htmlStr) {
        if (htmlStr) {
            htmlStr = htmlStr.replace(/&lt;/g, "<");
            htmlStr = htmlStr.replace(/&gt;/g, ">");
            htmlStr = htmlStr.replace(/&quot;/g, "\"");
            htmlStr = htmlStr.replace(/&#039;/g, "\'");
            htmlStr = htmlStr.replace(/&amp;/g, "&");
            htmlStr = htmlStr.replace(/<br>/g, "\n");
            return htmlStr;
        }
    };
    $('#dataTable tbody').on('click', '#modifier', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id = data[7];
        var nom = unEscape(data[1]);
        var adresse = unEscape(data[2]);
        var telephone = unEscape(data[3]);
        var email = unEscape(data[4]);

        $('#id_gare').val(id);
        $('#nom_modif').val(nom);
        $('#adresse_modif').val(adresse);
        $('#telephone_modif').val(telephone);
        $('#email_modif').val(email);
        
    });

    //Supprimer utilisateur
    $('#dataTable tbody').on('click', '#supprimer', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id_gare = data[7];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer la gare ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer la gare",
            cancelButtonText: "Annuler"
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    window.location.href= './../api/modules/supprimer_gare.php?id_gare=' + id_gare;
                
                }
                else
                {

                }
            })
        

    });
});
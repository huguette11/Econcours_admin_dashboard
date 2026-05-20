$(document).ready(function() {
    var tab=$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/utilisateur_data.php',
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
                defaultContent: '<span  title="Modifier l\'utilisateur"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Utilisateur btn btn-warning" href="#modifier_utilisateur" ><i class="fa  fa-pencil "></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false
            },
            {
                targets: [10],
                data: null,
                defaultContent: '<span  title="Supprimer l\'utilisateur"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',    
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

        var id = data[11];
        var nom = unEscape(data[1]);
        var prenom = unEscape(data[2]);
        var date_naissance = unEscape(data[3]);
        var telephone = unEscape(data[4]);
        var email = unEscape(data[5]);
        var adresse = unEscape(data[6]);
        var username = unEscape(data[7]);
        var type_compte = data[8];

        $('#id_utilisateur').val(id);
        $('#nom_modif').val(nom);
        $('#prenom_modif').val(prenom);
        $('#date_naissance_modif').val(date_naissance);
        $('#telephone_modif').val(telephone);
        $('#email_modif').val(email);
        $('#adresse_modif').val(adresse);
        $('#username_modif').val(username);
        $('#type_compte_modif').val(type_compte);
        
    });

    //Supprimer utilisateur
    $('#dataTable tbody').on('click', '#supprimer', function () {
        var data = tab.row($(this).parents('tr')).data();

        var id_utilisateur = data[11];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer l'utilisateur ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer l'utilisateur",
            cancelButtonText: "Annuler"
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    window.location.href= './../api/modules/supprimer_utilisateur.php?id_utilisateur=' + id_utilisateur;
                
                }
                else
                {

                }
            })
        

    });
});
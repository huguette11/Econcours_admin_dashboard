$(document).ready(function() {
    var tab=$('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '../api/modules/chauffeur_data.php',
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
                defaultContent: '<span  title="Modifier le chauffeur"><button data-toggle="modal" id="modifier" data-backdrop="false"  class="open-Modifier_Chauffeur btn btn-warning" href="#modifier_chauffeur" ><i class="fa  fa-pencil "></i></button></span>',    
                createdCell: function (td) {
                    
                    $(td).css('text-align', 'center')
                    
                },
                orderable:false
            },
            {
                targets: [7],
                data: null,
                defaultContent: '<span  title="Supprimer le chauffeur"><button id="supprimer" data-toggle="modal" data-backdrop="false" class="btn btn-danger" type="submit"  ><i class="fa fa-trash"></i></button></span>',    
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

        var id = data[8];
        var id_gare = data[9];
        var nom_chauffeur = unEscape(data[2]);
        var prenom = unEscape(data[3]);
        var telephone = unEscape(data[4]);
        var permis = unEscape(data[5]);

        $('#id_chauffeur').val(id);
        $('#id_gare_modif').val(id_gare);
        $('#nom_chauffeur_modif').val(nom_chauffeur);
        $('#prenom_modif').val(prenom);
        $('#telephone_modif').val(telephone);
        $('#permis_modif').val(permis);

        // ouvre modal et set selectize (tu peux garder ton setTimeout si nécessaire)
        $('#modifier_chauffeur').modal('show');
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

        var id_chauffeur = data[8];
        Swal.fire({
            title: 'Etes-vous sûr ?',
            text: "Voulez-vous vraiment supprimer le chauffeur ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b6c6c',
            confirmButtonText: "Oui, supprimer le chauffeur",
            cancelButtonText: "Annuler"
            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    window.location.href= './../api/modules/supprimer_chauffeur.php?id_chauffeur=' + id_chauffeur;
                
                }
                else
                {

                }
            })
        

    });
    let selectizeAjoutChauffeur;

    $(document).ready(function () {
        $('#id_gare').selectize({ sortField: 'text' })
    });
});
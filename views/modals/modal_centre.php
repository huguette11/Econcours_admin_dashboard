<div class="modal fade" id="ajouter_centre" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau centre</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAjoutCentre">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="nom">Nom (*)</label>
                                <input id="nom" class="form-control" type="text" name="nom" placeholder="Entrer le nom " required>                       
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

<div class="modal fade" id="modifier_centre" tabindex="-1" role="dialog">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Modifier un centre
                </h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formUpdateCentre">

                <div class="modal-body">

                    <input
                        type="hidden"
                        id="id_centre_modif"
                    >

                    <div class="form-group">

                        <label>Nom du centre</label>

                        <input
                            type="text"
                            id="nom_centre_modif"
                            class="form-control"
                            required
                        >

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Annuler
                    </button>

                    <button
                        type="submit"
                        class="btn btn-warning"
                    >
                        Modifier
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
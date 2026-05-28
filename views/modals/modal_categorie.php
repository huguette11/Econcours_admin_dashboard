<div class="modal fade" id="ajouter_categorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'une nouvelle catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formAjoutCategorie">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="libelle">Libellé(*)</label>
                                <input id="libelle" class="form-control" type="text" name="libelle" placeholder="Entrer le libellé " required>                       
                            </div>

                        </div>
                        
                    </div> 

                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" name="description" placeholder="Entrer la description " ></textarea>                       
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

<div class="modal fade" id="modifier_categorie" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'une catégorie</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formModificationCategorie">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_categorie" type="hidden" class="form-control"  name="id_categorie">

                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="libelle_modif">Libellé (*)</label>
                                <input id="libelle_modif" class="form-control" type="text" name="libelle" placeholder="Entrer le libellé " required>
                        
                            </div>
                
                        </div>
                        
                    </div> 

                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="description_modif">Description</label>
                                <textarea id="description_modif" class="form-control" name="description" placeholder="Entrer la description " ></textarea>                       
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
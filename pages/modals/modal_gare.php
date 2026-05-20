<div class="modal fade" id="ajouter_gare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'une nouvelle gare</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_gare.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-6">
                                <label for="nom">Nom (*)</label>
                                <input id="nom" class="form-control" type="text" name="nom" placeholder="Entrer le nom " required>                       
                            </div>

                            <div class="col-md-6">
                                <label for="adresse">Adresse (s *)</label>
                                <input id="adresse" class="form-control" type="text" name="adresse" placeholder="Entrer l'adresse" required>
                            </div>

                        </div>
                        
                    </div> 
                                

                    <div class="form-group">
                        <div class="row">
                             <div class="col-md-6">
                                <label for="telephone">Téléphone</label>
                                <input id="telephone" class="form-control" type="text" name="telephone" placeholder="Entrer le téléphone" required>
                            </div>

                            <div class="col-md-6">
                                <label for="email">Email (*)</label>
                                <input id="email" class="form-control" type="email" name="email" placeholder="Entrer l'email" required>
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

<div class="modal fade" id="modifier_gare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'une gare</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_gare.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_gare" type="hidden" class="form-control"  name="id_gare"  >

                        <div class="row">
                            
                            <div class="col-md-6">
                                <label for="nom_modif">Nom (*)</label>
                                <input id="nom_modif" class="form-control" type="text" name="nom" placeholder="Entrer le nom " required>
                        
                            </div>

                            <div class="col-md-6">
                                <label for="adresse_modif">Adresse (s *)</label>
                                <input id="adresse_modif" class="form-control" type="text" name="adresse" placeholder="Entrer l'adresse" required>
                            </div>

                        </div>
                        
                    </div> 
                                

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="telephone_modif">Téléphone (*)</label>
                                <input id="telephone_modif" class="form-control" type="text" name="telephone" placeholder="Entrer le numéro de téléphone" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email_modif">Email (*)</label>
                                <input id="email_modif" class="form-control" type="email" name="email" placeholder="Entrer l'email" required>
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
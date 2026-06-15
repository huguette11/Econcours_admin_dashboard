<div class="modal fade" id="ajouter_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouvel admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="adminForm">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-4">
                                <label for="nom">Nom (*)</label>
                                <input id="nom" class="form-control" type="text" name="nom" placeholder="Entrer le nom " required>                       
                            </div>

                            <div class="col-md-4">
                                <label for="prenom">Prénom (s *)</label>
                                <input id="prenom" class="form-control" type="text" name="prenom" placeholder="Entrer le prénom" required>
                            </div>

                            <div class="col-md-4">
                                <label for="email">Email (*)</label>
                                <input id="email" class="form-control" type="email" name="email" placeholder="Entrer l'email" required>
                            </div>
                        </div>
                        
                    </div> 
                                

                    <div class="form-group">
                        <div class="row">
                                                       
                            <div class="col-md-4">
                                <label for="telephone">Téléphone</label>
                                <input id="telephone" class="form-control" type="text" name="telephone" placeholder="Entrer le téléphone" required>
                            </div>

                            <div class="col-md-4">
                                <label for="role">Rôle (*)</label>
                                <select id="role" class="form-control" name="role" required>
                                    <option value="SUPERADMIN"> Administrateur</option>
                                    <option value="GESTIONNAIRE">Gestionnaire</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="mot_de_passe">Mot de passe (*)</label>
                                <input id="mot_de_passe" class="form-control" type="password" name="mot_de_passe" placeholder="Entrer le mot de passe" required>        
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

<div class="modal fade" id="modifier_admin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un administrateur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_admin.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_admin" type="hidden" class="form-control"  name="id_admin">

                        <div class="row">
                            
                            <div class="col-md-4">
                                <label for="nom_modif">Nom (*)</label>
                                <input id="nom_modif" class="form-control" type="text" name="nom" placeholder="Entrer le nom " required>
                        
                            </div>

                            <div class="col-md-4">
                                <label for="prenom_modif">Prénom (s *)</label>
                                <input id="prenom_modif" class="form-control" type="text" name="prenom" placeholder="Entrer le prénom" required>
                            </div>

                            <div class="col-md-4">
                                <label for="date_naissance_modif">Date de naissance</label>
                                <input id="date_naissance_modif" class="form-control" type="date" name="date_naissance" placeholder="Entrer la date de naissance" >
                            </div>

                            <div class="col-md-4">
                                <label for="telephone_modif">Téléphone</label>
                                <input id="telephone_modif" class="form-control" type="text" name="telephone" placeholder="Entrer le numéro de téléphone" >
                            </div>
                        </div>
                        
                    </div> 
                                

                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-4">
                                <label for="email_modif">Email (*)</label>
                                <input id="email_modif" class="form-control" type="email" name="email" placeholder="Entrer l'email" required>
                            </div>

                            <div class="col-md-4">
                                <label for="adresse_modif">Adresse</label>
                                <input id="adresse_modif" class="form-control" type="texte" name="adresse" placeholder="Entrer l'adresse" required>
                            </div>

                            <div class="col-md-4">
                                <label for="username_modif">Nom d'utilisateur (*)</label>
                                <input id="username_modif" class="form-control" type="text" name="username" placeholder="Entrer le nom d'utilisateur"  required>
                            </div>

                            <div class="col-md-4">
                                <label for="type_compte_modif">Type de compte (*)</label>
                                <select id="type_compte_modif" name="type_compte" class=form-control>
                                    <option value="Administrateur" >Administrateur</option>
                                </select>                          
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
<div class="modal fade" id="ajouter_examen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouvel examen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_examen.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            
                            <div class="col-md-4">
                                <label for="date_examen">Date de l'examen (*)</label>
                                <input id="date_examen" class="form-control" type="text" name="date_examen" placeholder="Entrer la date de l'examen " required>                       
                            </div>

                            <div class="col-md-4">
                                <label for="heure">Heure (*)</label>
                                <input id="heure" class="form-control" type="time" name="heure" placeholder="Entrer l'heure" required>
                            </div>

                            <div class="col-md-4">
                                <label for="lieu">Lieu (*)</label>
                                <input id="lieu" class="form-control" type="text" name="lieu" placeholder="Entrer le lieu" required>
                            </div>
                        </div>
                        
                    </div> 
                                

                    <div class="form-group">
                        <div class="row">
                                                       
                            <div class="col-md-4">
                                <label for="coefficient">Coefficient (*)</label>
                                <input id="coefficient" class="form-control" type="number" name="coefficient" placeholder="Entrer le coefficient" required>
                            </div>

                            <div class="col-md-4">
                                <label for="intitule">Intitulé (*)</label>
                                <input id="intitule" class="form-control" type="text" name="intitule" placeholder="Entrer l'intitulé" required>        
                            </div>

                            <div class="col-md-4">
                                <label for="type_examen">Type d'examen (*)</label>
                                <select id="type_examen" name="type_examen" class=form-control>
                                    <option value="Ecrit" >Ecrit</option>
                                    <option value="Pratique" >Pratique</option>
                                </select>
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

<div class="modal fade" id="modifier_examen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un examen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_examen.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_examen" type="hidden" class="form-control"  name="id_examen">

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
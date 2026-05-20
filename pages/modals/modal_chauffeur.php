<div class="modal fade" id="ajouter_chauffeur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau chauffeur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_chauffeur.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="id_gare">Gare</label>

                                <select id="id_gare" class="demo-default" name="id_gare"
                                    placeholder="Select une gare...">
                                    <option value="">Selectionnez une gare...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_gare, nom FROM gare where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<option value="' . $row['id_gare'] . '">[' . $row['id_gare'] . '] ' . $row['nom'] . '</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>
                            
                            <div class="col-md-4">
                                <label for="nom_chauffeur">Nom (*)</label>
                                <input id="nom_chauffeur" class="form-control" type="text" name="nom_chauffeur" placeholder="Entrer le nom " required>                       
                            </div>

                            <div class="col-md-4">
                                <label for="prenom">Prénom (s *)</label>
                                <input id="prenom" class="form-control" type="text" name="prenom" placeholder="Entrer le prénom" required>
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
                                <label for="permis">Permis (*)</label>
                                <input id="permis" class="form-control" type="text" name="permis" placeholder="Entrer le permis" required>
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

<div class="modal fade" id="modifier_chauffeur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un chauffeur</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_chauffeur.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_chauffeur" type="hidden" class="form-control"  name="id_chauffeur"  >

                        <div class="row">

                            <div class="col-md-4">
                                <label for="id_gare">Gare</label>

                                <select id="id_gare_modif" class="demo-default" name="id_gare"
                                    placeholder="Select une gare...">
                                    <option value="">Selectionner une gare...</option>
                                    <?php
                                    include('./../api/modules/connect_db.php');
                                    $query = "SELECT id_gare, nom FROM gare where suppression = 'Non'";
                                    $result = mysqli_query($db, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '<option value="' . $row['id_gare'] . '">[' . $row['id_gare'] . '] ' . $row['nom'] . '</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>
                            
                            <div class="col-md-4">
                                <label for="nom_chauffeur_modif">Nom (*)</label>
                                <input id="nom_chauffeur_modif" class="form-control" type="text" name="nom_chauffeur" placeholder="Entrer le nom " required>

                            </div>

                            <div class="col-md-4">
                                <label for="prenom_modif">Prénom (s *)</label>
                                <input id="prenom_modif" class="form-control" type="text" name="prenom" placeholder="Entrer le prénom" required>
                            </div>

                        </div>
                        
                    </div> 
                                

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="telephone_modif">Téléphone</label>
                                <input id="telephone_modif" class="form-control" type="text" name="telephone" placeholder="Entrer le numéro de téléphone" >
                            </div>

                            <div class="col-md-4">
                                <label for="permis_modif">Permis (*)</label>
                                <input id="permis_modif" class="form-control" type="text" name="permis" placeholder="Entrer le numéro de permis" required>
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
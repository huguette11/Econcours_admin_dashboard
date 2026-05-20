<div class="modal fade" id="ajouter_trajet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau trajet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_trajet.php" method="POST">
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

                                        echo '<option value="' . $row['id_gare'] . '">' . $row['nom'] . '</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="ville_depart">Ville de départ (*)</label>
                                <input id="ville_depart" class="form-control" type="text" name="ville_depart" placeholder="Entrer la ville de départ" required>
                            </div>

                            <div class="col-md-4">
                                <label for="ville_arrivee">Ville d'arrivée (*)</label>
                                <input id="ville_arrivee" class="form-control" type="text" name="ville_arrivee" placeholder="Entrer la ville d'arrivée" required>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="distance">Distance (*)</label>
                                <input id="distance" class="form-control" type="text" name="distance" placeholder="Entrer la distance" required>
                            </div>

                            <div class="col-md-4">
                                <label for="heure_depart">Heure de départ (*)</label>
                                <input id="heure_depart" class="form-control" type="time" name="heure_depart" required>
                            </div>

                            <div class="col-md-4">
                                <label for="heure_arrivee">Heure d'arrivée (*)</label>
                                <input id="heure_arrivee" class="form-control" type="time" name="heure_arrivee" required>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="prix">Prix (*)</label>
                                <input id="prix" class="form-control" type="number" name="prix" placeholder="Entrer le prix" required>
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

<div class="modal fade" id="modifier_trajet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un trajet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_trajet.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_trajet" type="hidden" class="form-control" name="id_trajet">

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

                                        echo '<option value="' . $row['id_gare'] . '">' . $row['nom'] . '</option>';
                                    }
                                    mysqli_close($db);
                                    ?>

                                </select>

                            </div>

                            <div class="col-md-4">
                                <label for="ville_depart_modif">Ville de départ (*)</label>
                                <input id="ville_depart_modif" class="form-control" type="text" name="ville_depart" placeholder="Entrer la ville de départ" required>

                            </div>

                            <div class="col-md-4">
                                <label for="ville_arrivee_modif">Ville d'arrivée (*)</label>
                                <input id="ville_arrivee_modif" class="form-control" type="text" name="ville_arrivee" placeholder="Entrer la ville d'arrivée" required>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="distance_modif">Distance (*)</label>
                                <input id="distance_modif" class="form-control" type="number" name="distance" placeholder="Entrer la distance" required>
                            </div>

                            <div class="col-md-4">
                                <label for="heure_depart_modif">Heure de départ (*)</label>
                                <input id="heure_depart_modif" class="form-control" type="time" name="heure_depart" required>
                            </div>

                            <div class="col-md-4">
                                <label for="heure_arrivee_modif">Heure d'arrivée (*)</label>
                                <input id="heure_arrivee_modif" class="form-control" type="time" name="heure_arrivee" required>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="prix_modif">Prix (*)</label>
                                <input id="prix_modif" class="form-control" type="number" name="prix" placeholder="Entrer le prix" required>
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
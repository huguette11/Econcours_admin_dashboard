<div class="modal fade" id="ajouter_car" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau car</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_car.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="id_gare">Gare</label>

                                <select id="id_gare" class="demo-default" name="id_gare"
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
                                <label for="immatriculation">Immatriculation (*)</label>
                                <input id="immatriculation" class="form-control" type="text" name="immatriculation" placeholder="Entrer l'immatriculation" required>
                            </div>

                            <div class="col-md-4">
                                <label for="modele">Modèle (*)</label>
                                <input id="modele" class="form-control" type="text" name="modele" placeholder="Entrer le modèle" required>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="capacite">Capacité (*)</label>
                                <input id="capacite" class="form-control" type="text" name="capacite" placeholder="Entrer la capacité" required>
                            </div>

                            <div class="col-md-4">
                                <label for="etat">État (*)</label>
                                <input id="etat" class="form-control" type="text" name="etat" placeholder="Entrer l'état" required>
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

<div class="modal fade" id="modifier_car" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un car</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_car.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_car" type="hidden" class="form-control" name="id_car">

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
                                <label for="immatriculation_modif">Immatriculation (*)</label>
                                <input id="immatriculation_modif" class="form-control" type="text" name="immatriculation" placeholder="Entrer l'immatriculation" required>

                            </div>

                            <div class="col-md-4">
                                <label for="modele_modif">Modèle (*)</label>
                                <input id="modele_modif" class="form-control" type="text" name="modele" placeholder="Entrer le modèle" required>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label for="capacite_modif">Capacité (*)</label>
                                <input id="capacite_modif" class="form-control" type="text" name="capacite" placeholder="Entrer la capacité" required>
                            </div>

                            <div class="col-md-4">
                                <label for="etat_modif">État (*)</label>
                                <input id="etat_modif" class="form-control" type="text" name="etat" placeholder="Entrer l'état" required>
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
<div class="modal fade" id="ajouter_concours" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau concours</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_concours.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Nom <span class="required">*</span></label>
                                <input type="text" name="nom" class="form-control" placeholder="Nom du concours" required>
                            </div>

                            <div class="col-md-4">
                                <label>Type de concours <span class="required">*</span></label>
                                <select required name="type" class="form-control">
                                    <option value="">Sélectionnez le type de concours</option>
                                    <option value="Direct">Direct</option>
                                    <option value="Professionnel">Professionnel</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Description <span class="required">*</span></label>
                                <textarea name="description" class="form-control" placeholder="Description du concours" required></textarea>
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Frais d'inscription <span class="required">*</span></label>
                                <input type="text" name="frais_inscription" class="form-control" placeholder="Frais d'inscription" required>
                            </div>

                            <div class="col-md-4">
                                <label>Nombre de postes <span class="required">*</span></label>
                                <input type="number" name="nombre_postes" class="form-control" placeholder="Nombre de postes" required>
                            </div>

                            <div class="col-md-4">
                                <label>Année <span class="required">*</span></label>
                                <input type="text" name="annee" class="form-control" placeholder="Année" required>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Date de début <span class="required">*</span></label>
                                <input type="date" name="date_debut" class="form-control" placeholder="Date de début" required>
                            </div>

                            <div class="col-md-4">
                                <label>Date de fin <span class="required">*</span></label>
                                <input type="date" name="date_fin" class="form-control" placeholder="Date de fin" required>
                            </div>

                            <div class="col-md-4">
                                <label>Statut du concours <span class="required">*</span></label>
                                <select required name="statut_concours" class="form-control">
                                    <option value="">Sélectionnez le statut du concours</option>
                                    <option value="Ouvert">Ouvert</option>
                                    <option value="Fermé">Fermé</option>
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

<div class="modal fade" id="modifier_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modification d'un client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/modifier_client.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <input id="id_client" type="hidden" class="form-control" name="id_client">

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
                                <label for="num_cnib_modif">Numéro CNIB/Passport</label>
                                <input id="num_cnib_modif" class="form-control" type="text" name="num_cnib" placeholder="Entrer le numéro CNIB/Passport">
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
                                <label for="telephone_modif">Téléphone</label>
                                <input id="telephone_modif" class="form-control" type="text" name="telephone" placeholder="Entrer le numéro de téléphone">
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
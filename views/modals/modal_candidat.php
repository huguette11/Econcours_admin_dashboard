<div class="modal fade" id="ajouter_candidat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajout d'un nouveau candidat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../api/modules/ajouter_candidat.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Nom <span class="required">*</span></label>
                                <input type="text" name="nom" class="form-control" placeholder="Votre nom de famille" required>
                            </div>

                            <div class="col-md-4">
                                <label>Prénom(s) <span class="required">*</span></label>
                                <input type="text" name="prenom" class="form-control" placeholder="Vos prénoms" required>
                            </div>

                            <div class="col-md-4">
                                <label>Nom de jeune fille</label>
                                <input type="text" name="nom_jeune_fille" class="form-control" placeholder="Votre nom de jeune fille">
                            </div>

                        </div>

                    </div>


                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Lieu de naissance <span class="required">*</span></label>
                                <input type="text" name="lieu_naissance" class="form-control" placeholder="Votre lieu de naissance" required>
                            </div>

                            <div class="col-md-4">
                                <label>Date de naissance <span class="required">*</span></label>
                                <input type="date" name="date_naissance" class="form-control" placeholder="mm/dd/yyyy" required>
                            </div>

                            <div class="col-md-4">
                                <label>Pays de naissance <span class="required">*</span></label>
                                <input type="text" name="pays_naissance" class="form-control" placeholder="Votre pays de naissance" required>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Téléphone <span class="required">*</span></label>
                                <input type="text" name="telephone" class="form-control" placeholder="+226 XX XX XX XX" required>
                            </div>

                            <div class="col-md-4">
                                <label>Email <span class="required">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Votre adresse email" required>
                            </div>

                            <div class="col-md-4">
                                <label>Numéro CNIB <span class="required">*</span></label>
                                <input type="text" name="numero_cnib" class="form-control" required>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Date de délivrance <span class="required">*</span></label>
                                <input type="date" name="date_delivrance" class="form-control" placeholder="Date de délivrance" required>
                            </div>

                            <div class="col-md-4">
                                <label>Type de concours <span class="required">*</span></label>
                                <select required name="type_concours" class="form-control">
                                    <option value="">Sélectionnez le type de concours</option>
                                    <option value="Direct">Direct</option>
                                    <option value="Professionnel">Professionnel</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Emploi</label>
                                <input type="text" name="emploi" class="form-control" placeholder="Votre emploi">
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Matricule</label>
                                <input type="text" name="matricule" class="form-control" placeholder="Votre matricule">
                            </div>

                            <div class="col-md-4">
                                <label>Ministère</label>
                                <input type="text" name="ministere" class="form-control" placeholder="Votre ministère d'affectation">
                            </div>

                            <div class="col-md-4">
                                <label>Mot de passe <span class="required">*</span></label>
                                <input type="password" name="mot_de_passe" class="form-control" required>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

                            <div class="col-md-4">
                                <label>Confirmer mot de passe <span class="required">*</span></label>
                                <input type="password" name="mot_de_passe_confirm" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label>Recevoir le code OTP par <span class="required">*</span></label>
                                <select name="choix" class="form-control" required>
                                    <option value="">Choisir une option</option>
                                    <option value="mail">Email</option>
                                    <option value="sms">SMS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">

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
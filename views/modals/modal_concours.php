<div class="modal fade" id="ajouter_concours" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un concours</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- FORM -->
            <form id="formConcours">

                <div class="modal-body">

                    <!-- LIGNE 1 -->
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Nom</label>
                            <input type="text" name="nom" class="form-control" placeholder="Nom du concours" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="">Sélectionnez</option>
                                <option value="DIRECT">DIRECT</option>
                                <option value="PROFESSIONNEL">PROFESSIONNEL</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" placeholder="Description" rows="2"></textarea>
                        </div>

                    </div>

                    <!-- LIGNE 2 -->
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Frais d'inscription</label>
                            <input type="number" name="frais_inscription" class="form-control" placeholder="5000">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Nombre de postes</label>
                            <input type="number" name="nombre_postes" class="form-control" placeholder="100">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Année</label>
                            <input type="number" name="annee" class="form-control" placeholder="2027">
                        </div>

                    </div>

                    <!-- LIGNE 3 -->
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Date début</label>
                            <input type="date" name="date_debut" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Date fin</label>
                            <input type="date" name="date_fin" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Statut</label>
                            <select name="statut_concours" class="form-control">
                                <option value="">Sélectionnez</option>
                                <option value="OUVERT">OUVERT</option>
                                <option value="FERME">FERME</option>
                            </select>
                        </div>

                    </div>

                    <!-- LIGNE 4 -->
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Catégorie</label>
                            <select name="categorieId" id="categorieId" class="form-control" required>
                                <option value="">Sélectionnez</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Centres <small class="text-muted">(Ctrl+clic pour sélectionner plusieurs)</small></label>
                            <select name="centres" id="centres" class="form-control" multiple required>
                                <option value="">Sélectionnez</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>

            </form>

        </div>

    </div>

</div>

<div class="modal fade" id="modifier_concours" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title">Modifier un concours</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <!-- FORM -->
            <form id="formUpdateConcours">

                <div class="modal-body">

                    <input type="hidden" id="id_concours_modif">

                    <!-- LIGNE 1 -->
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Nom</label>
                            <input type="text" id="nom_modif" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Type</label>
                            <select id="type_modif" class="form-control">
                                <option value="DIRECT">DIRECT</option>
                                <option value="PROFESSIONNEL">PROFESSIONNEL</option>
                                <option value="HANDICAPE">HANDICAPE</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Description</label>
                            <textarea id="description_modif" class="form-control" rows="2"></textarea>
                        </div>

                    </div>

                    <!-- LIGNE 2 -->
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Frais inscription</label>
                            <input type="number" id="frais_inscription_modif" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Nombre de postes</label>
                            <input type="number" id="nombre_postes_modif" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Année</label>
                            <input type="number" id="annee_modif" class="form-control">
                        </div>

                    </div>

                    <!-- LIGNE 3 -->
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label>Date début</label>
                            <input type="date" id="date_debut_modif" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Date fin</label>
                            <input type="date" id="date_fin_modif" class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Statut</label>
                            <select id="statut_concours_modif" class="form-control">
                                <option value="OUVERT">OUVERT</option>
                                <option value="FERME">FERME</option>
                                <option value="EN_ATTENTE">EN_ATTENTE</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Annuler
                    </button>

                    <button type="submit" class="btn btn-warning">
                        Modifier
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>
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
                            <select name="categorieId" class="form-control" required>
                                <option value="">Sélectionnez</option>
                                <option value="1">Fonction Publique</option>
                                <option value="2">Militaire</option>
                                <option value="3">Paramédical</option>
                                <option value="4">Enseignement</option>
                                <option value="5">Police Nationale</option>
                                <option value="6">Douanes</option>
                                <option value="7">Eaux et Forêts</option>
                                <option value="8">Justice</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Centres <small class="text-muted">(Ctrl+clic pour sélectionner plusieurs)</small></label>
                            <select name="centres" class="form-control" multiple required style="height: 150px;">
                                <option value="1">Ouagadougou</option>
                                <option value="2">Bobo-Dioulasso</option>
                                <option value="3">Koudougou</option>
                                <option value="4">Banfora</option>
                                <option value="5">Ouahigouya</option>
                                <option value="6">Dédougou</option>
                                <option value="7">Fada N'Gourma</option>
                                <option value="8">Tenkodogo</option>
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
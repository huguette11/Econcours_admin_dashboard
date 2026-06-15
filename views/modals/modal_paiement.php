<div class="modal fade" id="detailPaiementModal" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header text-white">

                <h5 class="modal-title">
                    Détail du paiement
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>

            <!-- BODY -->
            <div class="modal-body" id="detailPaiementContent">

                <hr>

                <div class="form-group">
                    <label>Modifier statut</label>

                    <select id="statutPaiementSelect" class="form-control">
                        <option value="EN_ATTENTE">EN_ATTENTE</option>
                        <option value="VALIDÉ">VALIDÉ</option>
                        <option value="REFUSÉ">REFUSÉ</option>
                    </select>

                    <button id="btnUpdatePaiement" class="btn btn-success mt-2">
                        Mettre à jour
                    </button>
                </div>

                <div class="text-center text-muted">
                    Chargement...
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">

                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    Fermer
                </button>

            </div>

        </div>

    </div>

</div>
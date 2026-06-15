import PaiementModel from "../models/PaiementModel.js";
import AdminController from "./AdminController.js";

export default class PaiementController {

    static async loadPaiementsByCandidat() {

        const token = AdminController.getToken();

        const res = await PaiementModel.getPaiementByCandidat(token);

        const tbody = document.querySelector("#paiementTable tbody");

        tbody.innerHTML = "";

        const data = Object.values(res.data.data);
        console.log(res.data.data);

        data.forEach((item, index) => {
            console.log(item);

            const total = item.paiements.reduce(
                (sum, p) => sum + Number(p.montant),
                0
            );

            const preview = item.paiements.slice(0, 2).map(p => `
            <div>
                <b>${p.inscription.concours.nom}</b>
                - ${p.montant} FCFA
            </div>
        `).join("");

            tbody.innerHTML += `
            <tr>

                <td class="text-center">${index + 1}</td>

                <td class="text-center">
                    ${item.candidat.nom} ${item.candidat.prenom}
                </td>

                <td class="text-center">
                    ${preview}

                    ${item.paiements.length > 2
                    ? `<span class="badge badge-info">
                              +${item.paiements.length - 2} autres
                           </span>`
                    : ""
                }
                </td>

                <td class="text-center">
                    <strong>${total.toLocaleString()} FCFA</strong>
                </td>

                <td class="text-center">
                    <button class="btn btn-info btn-sm btn-detail-paiement"
                        data-id="${item.candidat.id_candidat}">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>

            </tr>
        `;
        });

        this.initPaiementDataTable();

    }

    static initPaiementDataTable() {

        if ($.fn.DataTable.isDataTable("#paiementTable")) {
            $("#paiementTable").DataTable().destroy();
        }

        $("#paiementTable").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
            }
        });
    }

    static initPaiementEvents() {

        document.body.addEventListener("click", async (e) => {

            const btn = e.target.closest(".btn-detail-paiement");

            if (!btn) return;

            console.log("CLICK DETECTÉ :", btn.dataset.id);

            await PaiementController.showPaiementDetail(btn.dataset.id);
        });
    }
    static currentPaiement = null;
    static async showPaiementDetail(idCandidat) {
        console.log("ID candidat :", idCandidat);

        const token = AdminController.getToken();

        const res = await PaiementModel.getPaiementDetail(token, idCandidat);

        console.log("Réponse API :", res);

        if (!res.ok) {
            Swal.fire("Erreur", "Impossible de charger les paiements", "error");
            return;
        }

        const paiements = res.data.data;

        console.log("Paiements :", paiements);

        if (!paiements || paiements.length === 0) {
            Swal.fire("Info", "Aucun paiement trouvé", "info");
            return;
        }

        PaiementController.currentPaiement = paiements[0].id_paiement;
        PaiementController.currentCandidat = idCandidat;
        // IMPORTANT : le candidat vient du premier paiement
        const candidat = paiements[0].inscription.candidat;

        let html = `
        <div class="row">

            <div class="col-md-6">
                <p><strong>Nom :</strong> ${candidat.nom}</p>
                <p><strong>Prénom :</strong> ${candidat.prenom}</p>
            </div>

            <div class="col-md-6">
                <p><strong>Email :</strong> ${candidat.email || "-"}</p>
                <p><strong>CNIB :</strong> ${candidat.numero_cnib || "-"}</p>
            </div>

        </div>

        <hr>

        <h5>Détail des paiements</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Concours</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Mode</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
    `;

        paiements.forEach(p => {

            html += `
            <tr data-id="${p.id_paiement}">
                <td>${p.id_paiement}</td>
                <td>${p.inscription.concours.nom}</td>
                <td>${Number(p.montant).toLocaleString()} FCFA</td>
                <td>${new Date(p.date_paiement).toLocaleString()}</td>
                <td>${p.mode_paiement || "-"}</td>
                <td>
                    <select class="form-control statut-select">
                        <option value="ATTENTE" ${p.statut_paiement === "ATTENTE" ? "selected" : ""}>ATTENTE</option>
                        <option value="REUSSI" ${p.statut_paiement === "REUSSI" ? "selected" : ""}>REUSSI</option>
                        <option value="ECHOUE" ${p.statut_paiement === "ECHOUE" ? "selected" : ""}>ECHOUE</option>
                    </select>
                </td>
        
            </tr>
        `;
        });

        html += `</tbody></table>`;

        document.getElementById("detailPaiementContent").innerHTML = html;

        console.log("Avant ouverture modal");

        $("#detailPaiementModal").modal("show");

        console.log("Après ouverture modal");
    }

    static initPaiementStatusInlineEdit() {

        document.addEventListener("change", async (e) => {

            const select = e.target.closest(".statut-select");
            if (!select) return;

            const row = select.closest("tr");
            const id_paiement = row.dataset.id;

            const token = AdminController.getToken();

            const statut_paiement = select.value;

            // 1. update visuel immédiat
            // PaiementController.updateSelectColor(select);

            // 2. update backend
            const res = await PaiementModel.updatePaiementStatus(
                token,
                id_paiement,
                PaiementController.currentCandidat,
                statut_paiement
            );

            if (!res.ok) {
                Swal.fire("Erreur", "Modification échouée", "error");
                return;
            }

            // 3. feedback léger
            Swal.fire({
                icon: "success",
                title: "Statut mis à jour",
                timer: 800,
                showConfirmButton: false
            });
            select.classList.remove(
                "border-success",
                "border-warning",
                "border-danger"
            );

            if (select.value === "REUSSI") {
                select.classList.add("border-success");
            }

            else if (select.value === "ECHOUE") {
                select.classList.add("border-danger");
            }

            else {
                select.classList.add("border-warning");
            }

            select.style.transition = "0.2s";
            select.style.transform = "scale(1.05)";

            setTimeout(() => {
                select.style.transform = "scale(1)";
            }, 150);
        });

    }

}
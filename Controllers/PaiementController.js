import PaiementModel from "../models/PaiementModel.js";
import AdminController from "./AdminController.js";

export default class PaiementController {

    static async getAll(params) {

        const token = AdminController.getToken();

        if (!token) {

            window.location.href = "../login.php";

            return {
                draw: params?.draw ?? 0,
                recordsTotal: 0,
                recordsFiltered: 0,
                data: []
            };
        }

        const res =
            await PaiementModel.getAllPaiements(
                token,
                params
            );

        if (!res.ok) {

            Swal.fire({
                icon: "error",
                title: "Erreur",
                text:
                    res.data?.error ||
                    res.data?.message ||
                    "Impossible de charger les concours"
            });

            return {
                draw: params?.draw ?? 0,
                recordsTotal: 0,
                recordsFiltered: 0,
                data: []
            };
        }

        return res.data;
    }

    static loadPaiementsByCandidat() {


        this.initPaiementDataTable();
    }

    // ===== DATATABLE (LISTE DES CONCOURS) =====
    static initPaiementDataTable() {

        if ($.fn.DataTable.isDataTable("#paiementTable")) {

            return;
        }

        $("#paiementTable").DataTable({

            processing: true,

            serverSide: true,

            responsive: true,

            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],

            searching: true,

            ordering: true,

            info: true,

            searchDelay: 500,

            ajax: async function (data, callback) {

                try {

                    const params = {

                        draw: data.draw,

                        start: data.start,

                        length: data.length,

                        search:
                            data.search?.value || "",

                        orderColumn:
                            data.order?.[0]?.column ?? 1,

                        orderDir:
                            data.order?.[0]?.dir ?? "asc"
                    };

                    const result =
                        await PaiementController.getAll(params);

                    const concours =
                        Array.isArray(result?.data)
                            ? result.data
                            : [];

                    const rows =
                        concours.map(
                            (c, index) => [

                                params.start +
                                index +
                                1,

                                `<strong>${c.nom || "-"}</strong>`,

                                c.annee || "-",

                                `
                            <button
                                type="button"
                                class="btn btn-info btn-sm btn-detail-paiement"
                                data-id="${c.id_concours}"
                                title="Voir les paiements"
                            >
                                <i class="fa fa-eye"></i>
                            </button>
                        `
                            ]
                        );

                    callback({

                        draw: data.draw,

                        recordsTotal:
                            result?.recordsTotal ?? 0,

                        recordsFiltered:
                            result?.recordsFiltered ?? 0,

                        data: rows
                    });

                } catch (error) {

                    console.error(
                        "Erreur chargement concours :",
                        error
                    );

                    callback({

                        draw: data.draw,

                        recordsTotal: 0,

                        recordsFiltered: 0,

                        data: []
                    });
                }
            },

            columns: [

                {
                    title: "#",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },

                {
                    title: "Concours",
                    className: "text-center"
                },

                {
                    title: "Année",
                    className: "text-center"
                },

                {
                    title: "Détails",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }

            ],

            language: {
                url:
                    "https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
            },

            layout: {
                topStart: "pageLength",

                topEnd: "search",

                bottomStart: "info",

                bottomEnd: "paging"
            }


        });
    }

    static initPaiementEvents() {

        document.body.addEventListener("click", async (e) => {

            // ===== DETAIL CONCOURS (paiements des candidats) =====
            const btn = e.target.closest(".btn-detail-paiement");

            if (btn) {
                await PaiementController.showPaiementDetail(btn.dataset.id);
                return;
            }

            // ===== EXPORTS DU CONCOURS =====
            const btnExport = e.target.closest(".btn-export-paiement");

            if (btnExport) {
                await PaiementController.downloadExport(
                    btnExport.dataset.type,
                    btnExport.dataset.id
                );
            }
        });
    }

    // ===== DÉTAIL D'UN CONCOURS (PAIEMENTS DES CANDIDATS) =====
 static async showPaiementDetail(idConcours) {

    try {

        const token = AdminController.getToken();

        const res = await PaiementModel.getPaiementDetail(token, idConcours);

        if (!res.ok) {
            Swal.fire(
                "Info",
                res.data?.error || "Impossible de charger les paiements",
                "info"
            );
            return;
        }

        const paiements = res.data.data;

        if (!paiements || paiements.length === 0) {
            Swal.fire("Info", "Aucun paiement trouvé", "info");
            return;
        }

        // IMPORTANT : le concours vient du premier paiement
        const concours = paiements[0].inscription.concours;

        let html = `
        <div class="row">

            <div class="col-md-6">
                <p><strong>Concours :</strong> ${concours.nom}</p>
                <p><strong>Année :</strong> ${concours.annee || "-"}</p>
            </div>

            <div class="col-md-6">
                <p><strong>Type :</strong> ${concours.type || "-"}</p>
                <p><strong>Nombre de postes :</strong> ${concours.nombre_postes ?? "-"}</p>
            </div>

        </div>

        <div class="row text-center mb-3">

            <div class="col-md-4">
                <div class="border rounded p-2">
                    <small class="text-muted d-block">Montant payé</small>
                    <strong class="text-success" id="montantPaye">0 FCFA</strong>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border rounded p-2">
                    <small class="text-muted d-block">Montant en attente</small>
                    <strong class="text-warning" id="montantAttente">0 FCFA</strong>
                </div>
            </div>

            <div class="col-md-4">
                <div class="border rounded p-2">
                    <small class="text-muted d-block">Montant total prévu</small>
                    <strong id="montantPrevu">0 FCFA</strong>
                </div>
            </div>

        </div>

        <div class="mb-3">

            <button
                type="button"
                class="btn btn-success btn-sm btn-export-paiement"
                data-type="excel"
                data-id="${idConcours}">
                <i class="fa fa-file-excel"></i> Excel
            </button>

            <button
                type="button"
                class="btn btn-primary btn-sm btn-export-paiement"
                data-type="word"
                data-id="${idConcours}">
                <i class="fa fa-file-word"></i> Word
            </button>

            <button
                type="button"
                class="btn btn-danger btn-sm btn-export-paiement"
                data-type="pdf"
                data-id="${idConcours}">
                <i class="fa fa-file-pdf"></i> PDF
            </button>

        </div>

        <hr>

        <h5>Paiements des candidats (${paiements.length})</h5>
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Candidat</th>
                    <th>Email</th>
                    <th>NINA</th>
                    <th>Montant</th>
                    <th>Date</th>
                    <th>Mode</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
    `;

        paiements.forEach(p => {

            const candidat = p.inscription.candidat;

            html += `
            <tr data-id="${p.id_paiement}" data-candidat="${candidat.id_candidat}" data-montant="${Number(p.montant || 0)}">
                <td>${p.id_paiement}</td>
                <td>${candidat.nom} ${candidat.prenom}</td>
                <td>${candidat.email || "-"}</td>
                <td>${candidat.numero_cnib || "-"}</td>
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

        html += `</tbody></table></div>`;

        document.getElementById("detailPaiementContent").innerHTML = html;

        PaiementController.updateMontants();

        $("#detailPaiementModal").modal("show");

    } catch (error) {

        console.error("Erreur showPaiementDetail :", error);

        Swal.fire("Erreur", error.message, "error");
    }
}

static updateMontants() {

    let paye = 0;
    let attente = 0;

    document
        .querySelectorAll("#detailPaiementContent tbody tr")
        .forEach(row => {

            const montant = Number(row.dataset.montant || 0);
            const statut = row.querySelector(".statut-select")?.value;

            if (statut === "REUSSI") {
                paye += montant;
            } else if (statut === "ATTENTE") {
                attente += montant;
            }
        });

    const format = (n) => `${n.toLocaleString("fr-FR")} FCFA`;

    document.getElementById("montantPaye").textContent = format(paye);
    document.getElementById("montantAttente").textContent = format(attente);
    document.getElementById("montantPrevu").textContent = format(paye + attente);
}

    static initPaiementStatusInlineEdit() {

        document.addEventListener("change", async (e) => {

            const select = e.target.closest(".statut-select");
            if (!select) return;

            const row = select.closest("tr");
            const id_paiement = row.dataset.id;
            const id_candidat = row.dataset.candidat;

            const token = AdminController.getToken();

            const statut_paiement = select.value;

            // update backend
            const res = await PaiementModel.updatePaiementStatus(
                token,
                id_paiement,
                id_candidat,
                statut_paiement
            );

            if (!res.ok) {
                Swal.fire("Erreur", "Modification échouée", "error");
                return;
            }

            // feedback léger
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

    // ===== EXPORTS D'UN CONCOURS =====
    static async downloadExport(type, id_concours) {
        const token = AdminController.getToken();

        if (!token) {
            Swal.fire({
                icon: "warning",
                title: "Session expirée",
                text: "Veuillez vous reconnecter."
            });

            window.location.href = "../login.php";

            return;
        }

        try {
            const filters = {
                statut_paiement:
                    document.getElementById("filterStatutPaiement")?.value || "",

                mode_paiement:
                    document.getElementById("filterModePaiement")?.value || ""
            };

            Swal.fire({
                title: "Export en cours...",
                text: `Préparation du fichier ${type.toUpperCase()}.`,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let res;
            let extension;

            switch (type) {
                case "excel":
                    res = await PaiementModel.exportExcel(token, id_concours, filters);
                    extension = "xlsx";
                    break;

                case "word":
                    res = await PaiementModel.exportWord(token, id_concours, filters);
                    extension = "docx";
                    break;

                case "pdf":
                    res = await PaiementModel.exportPDF(token, id_concours, filters);
                    extension = "pdf";
                    break;

                default:
                    Swal.close();

                    Swal.fire({
                        icon: "error",
                        title: "Erreur",
                        text: "Type d'export invalide."
                    });

                    return;
            }

            if (!res.ok) {
                Swal.close();

                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: `Impossible d'exporter les paiements en ${type.toUpperCase()}.`
                });

                return;
            }

            const url = window.URL.createObjectURL(res.blob);

            const link = document.createElement("a");

            link.href = url;

            link.download =
                `paiements_concours_${id_concours}_${new Date().toISOString().slice(0, 10)}.${extension}`;

            document.body.appendChild(link);

            link.click();

            link.remove();

            window.URL.revokeObjectURL(url);

            Swal.close();

            Swal.fire({
                icon: "success",
                title: "Export terminé",
                text: `Les paiements du concours ont été exportés en ${type.toUpperCase()}.`,
                timer: 2000,
                showConfirmButton: false
            });

        } catch (error) {
            console.error(`Erreur export ${type} paiements :`, error);

            Swal.close();

            Swal.fire({
                icon: "error",
                title: "Erreur",
                text: "Une erreur est survenue pendant l'export."
            });
        }
    }

}
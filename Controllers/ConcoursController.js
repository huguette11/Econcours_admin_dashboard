import ConcoursModel from "../models/ConcoursModel.js";
import AdminController from "./AdminController.js";
import CategorieModel from "../models/CategorieModel.js";
import CentreModel from "../models/CentreModel.js";
import ExamenModel from "../models/ExamenModel.js";


export default class ConcoursController {

    // =========================================
    // GET ALL
    // =========================================
    static async getAll() {

        const token = AdminController.getToken();

        if (!token) {
            console.warn("Aucun token admin");
            return [];
        }

        const res = await ConcoursModel.getAllConcours(token);

        // console.log("REPONSE API :", res);

        if (!res.ok) {
            Alert.error("Erreur chargement concours");
            return [];
        }

        return res.data;

    }

    // =========================================
    // DATATABLE
    // =========================================
    static async initDataTable() {
        console.log("INIT DATATABLE");

        const tbody = document.getElementById("concoursTableBody");

        if (!tbody) {
            console.error("tbody concours introuvable");
            return;
        }

        const response = await this.getAll();

        const concours = response.data || [];

        console.log("LISTE CONCOURS :", concours);

        // Destroy ancienne DataTable
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        tbody.innerHTML = "";

        concours.forEach((item, index) => {

            tbody.innerHTML += `
                <tr>

                    <td class="text-center">
                        ${index + 1}
                    </td>

                    <td class="text-center">
                        ${item.nom || ""}
                    </td>

                    <td class="text-center">
                        ${item.type || ""}
                    </td>

                    <td class="text-center">
                        ${item.categorie?.libelle || ""}
                    </td>

                    <td class="text-center">
                         ${item.nombre_postes || ""}
                    </td>

                    <td class="text-center">
                        ${item.date_debut?.split("T")[0] || ""}
                    </td>

                    <td class="text-center">
                        ${item.date_fin?.split("T")[0] || ""}
                    </td>

                    <td class="text-center">

                        <select
                            class="form-control statut-select"
                            data-id="${item.id_concours}"
                        >
                            <option value="ATTENTE"
                                ${item.statut_concours === "ATTENTE" ? "selected" : ""}>
                                EN_ATTENTE
                            </option>

                            <option value="OUVERT"
                                ${item.statut_concours === "OUVERT" ? "selected" : ""}>
                                OUVERT
                            </option>

                            <option value="FERME"
                                ${item.statut_concours === "FERME" ? "selected" : ""}>
                                FERME
                            </option>
                        </select>

                    </td>

                     <td class="text-center">

                        <button 
                            class="btn btn-warning btn-sm btn-edit"
                            data-id="${item.id_concours}"
                            data-nom="${item.nom}"
                            data-type="${item.type}"
                            data-description="${item.description || ''}"
                            data-frais="${item.frais_inscription || ''}"
                            data-postes="${item.nombre_postes}"
                            data-annee="${item.annee}"
                            data-debut="${item.date_debut?.split('T')[0]}"
                            data-fin="${item.date_fin?.split('T')[0]}"
                            data-statut="${item.statut_concours}"
                        >
                            <i class="fa fa-edit"></i>
                        </button>

                    </td>

                    <td class="text-center">

                        <button 
                            class="btn btn-danger btn-sm btn-delete"
                            data-id="${item.id_concours}"
                        >
                            <i class="fa fa-trash"></i>
                        </button>

                    </td>

                    <td class="text-center">
                        <button
                            class="btn btn-info btn-sm btn-candidats"
                            data-id="${item.id_concours}"
                            data-nom="${item.nom}"
                            title="Voir les candidats"
                        >
                            <i class="fa-solid fa-users"></i>
                        </button>
                    </td>

                    <td class="text-center">
                        <button  
                            class="btn btn-warning btn-sm btn-examens"
                            data-id="${item.id_concours}"
                            data-nom="${item.nom}"
                            title="Voir les examens"
                        >
                            <i class="fa-solid fa-file-pen"></i>
                        </button>
                    </td>

                </tr>
            `;
        });


        // Nouvelle DataTable
        $('#dataTable').DataTable({
            responsive: true,
            paging: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            searching: true,
            ordering: true,
            info: true,

            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
            },


            layout: {
                topStart: [
                    'pageLength',
                    {
                        buttons: ['copy', 'excel', 'csv', 'pdf']
                    }
                ],
                topEnd: 'search',

                bottomStart: 'info',
                bottomEnd: 'paging'
            }
        });

        this.bindEvents();
    }

    static bindEvents() {

        document.addEventListener("click", async (e) => {

            // ==============================
            // VOIR LES EXAMENS
            // ==============================

            const btnExamen = e.target.closest(".btn-examens");

            if (btnExamen) {

                const id = btnExamen.dataset.id;
                const nom = btnExamen.dataset.nom;

                console.log("Bouton examens cliqué :", id, nom);

                await this.afficherExamens(id, nom);

                return;
            }


            // ==============================
            // VOIR LES CANDIDATS
            // ==============================

            const btnCandidats = e.target.closest(".btn-candidats");

            if (btnCandidats) {

                const id = btnCandidats.dataset.id;
                const nom = btnCandidats.dataset.nom;

                console.log("Bouton candidats cliqué :", id, nom);

                const token = AdminController.getToken();

                const res = await ConcoursModel.getCandidatsConcours(
                    token,
                    id
                );

                if (!res.ok) {
                    Alert.error(
                        res.data?.error ||
                        "Impossible de charger les candidats"
                    );
                    return;
                }

                console.log("Candidats :", res.data);

                this.afficherModalCandidats(
                    nom,
                    res.data
                );

                return;
            }

        });
    }

    static async afficherModalCandidats(nomConcours, candidats) {

        document.getElementById("titreModal").textContent =
            "Candidats - " + nomConcours;

        const tbody = document.getElementById("tbodyCandidats");
        tbody.innerHTML = "";

        if (candidats.length === 0) {
            tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center">
                    Aucun candidat inscrit
                </td>
            </tr>`;
        } else {

            candidats.forEach((c, index) => {

                tbody.innerHTML += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${c.candidat.nom}</td>
                    <td>${c.candidat.prenom}</td>
                    <td>${c.candidat.email}</td>
                    <td>${c.statut_inscription}</td>
                </tr>
            `;
            });
        }

        const modal = new bootstrap.Modal(document.getElementById("modalCandidats"));
        modal.show();
    }


    // =========================================
    // AJOUT
    // =========================================
    static initCreateConcours() {

        const form = document.getElementById("formConcours");

        if (!form) return;

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const token = AdminController.getToken();

            const data = {
                nom: document.querySelector("[name='nom']").value,
                type: document.querySelector("[name='type']").value,
                description: document.querySelector("[name='description']").value,
                nombre_postes: Number(document.querySelector("[name='nombre_postes']").value),
                annee: Number(document.querySelector("[name='annee']").value),
                date_debut: document.querySelector("[name='date_debut']").value,
                date_fin: document.querySelector("[name='date_fin']").value,
                statut_concours: document.querySelector("[name='statut_concours']").value,
                categorieId: Number(document.querySelector("[name='categorieId']").value),
                centres: $('#centres').val()?.map(Number) || []
            };

            const res = await ConcoursModel.createConcours(token, data);

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data?.error || res.data?.message || "Erreur création concours",
                    "error"
                );

                return;
            }

            Swal.fire(
                "Succès",
                res.data.message,
                "success"
            );

            form.reset();

            $("#ajouter_concours").modal("hide");

            await this.initDataTable();
        });
    }



    // =========================================
    // MODIFICATION
    // =========================================
    static initEditConcours() {

        const form = document.getElementById("formUpdateConcours");

        if (!form) return;

        // CLICK bouton EDIT
        document.addEventListener("click", (e) => {

            const btn = e.target.closest(".btn-edit");
            if (!btn) return;

            // remplir modal
            document.getElementById("id_concours_modif").value = btn.dataset.id;
            document.getElementById("nom_modif").value = btn.dataset.nom || "";
            document.getElementById("type_modif").value = btn.dataset.type || "";
            document.getElementById("description_modif").value = btn.dataset.description || "";
            document.getElementById("frais_inscription_modif").value = btn.dataset.frais || "";
            document.getElementById("nombre_postes_modif").value = btn.dataset.postes || "";
            document.getElementById("annee_modif").value = btn.dataset.annee || "";
            document.getElementById("date_debut_modif").value = btn.dataset.debut || "";
            document.getElementById("date_fin_modif").value = btn.dataset.fin || "";
            document.getElementById("statut_concours_modif").value = btn.dataset.statut || "";

            $("#modifier_concours").modal("show");
        });

        // SUBMIT UPDATE
        form.addEventListener("submit", async (e) => {

            e.preventDefault();
            console.log("SUBMIT UPDATE DECLENCHE");

            const token = AdminController.getToken();

            const id = document.getElementById("id_concours_modif").value;

            console.log("ID :", id);

            const data = {
                nom: document.getElementById("nom_modif").value,
                type: document.getElementById("type_modif").value,
                description: document.getElementById("description_modif").value,
                frais_inscription: Number(document.getElementById("frais_inscription_modif").value),
                nombre_postes: Number(document.getElementById("nombre_postes_modif").value),
                annee: Number(document.getElementById("annee_modif").value),
                date_debut: document.getElementById("date_debut_modif").value,
                date_fin: document.getElementById("date_fin_modif").value,
                statut_concours: document.getElementById("statut_concours_modif").value,
            };
            console.log("DATA :", data);
            const res = await ConcoursModel.updateConcours(id, token, data);
            console.log("REPONSE UPDATE :", res);
            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data.error || "Erreur modification concours",
                    "error"
                );

                return;
            }

            Swal.fire(
                "Succès",
                res.data.message,
                "success"
            );

            $("#modifier_concours").modal("hide");

            await this.initDataTable();
        });
    }
    // =========================================
    // SUPPRESSION
    // =========================================
    static initDeleteConcours() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest(".btn-delete");
            if (!btn) return;

            const id = btn.dataset.id;

            const confirm = await Swal.fire({
                title: "Confirmer suppression ?",
                text: "Cette action est irréversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui supprimer",
                cancelButtonText: "Annuler"
            });

            if (!confirm.isConfirmed) return;

            const token = AdminController.getToken();

            const res = await ConcoursModel.deleteConcours(id, token);

            if (!res.ok) {
                Swal.fire("Erreur", res.data.error || "Suppression échouée", "error");
                return;
            }

            Swal.fire("Succès", res.data.message, "success");

            await this.initDataTable();
        });
    }

    static initSwitchStatus() {

        document.addEventListener("change", async (e) => {

            const select = e.target.closest(".statut-select");

            if (!select) return;

            const id_concours = select.dataset.id;
            const statut_concours = select.value;

            const token = AdminController.getToken();

            const res = await ConcoursModel.switchStatutConcours(
                id_concours,
                statut_concours,
                token
            );

            console.log("ERREUR BACK :", res.data);

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data.error || "Impossible de modifier le statut",
                    "error"
                );

                return;
            }

            Swal.fire(
                "Succès",
                res.data.message,
                "success"
            );
        });
    }

    static async loadSelects() {

        const token = AdminController.getToken();

        // ===== CATEGORIES =====
        const catRes = await CategorieModel.getAllCategories(token);

        const catSelect = $('#categorieId');

        catSelect.empty().append('<option value=""></option>');

        if (catRes.ok) {
            catRes.data.data.forEach(cat => {
                catSelect.append(new Option(cat.libelle, cat.id));
            });
        }

        // ===== CENTRES =====
        const centreRes = await CentreModel.getAllCentres(token);

        const centreSelect = $('#centres');

        centreSelect.empty().append('<option value=""></option>');

        if (centreRes.ok) {
            centreRes.data.data.forEach(centre => {
                centreSelect.append(new Option(centre.nom, centre.id_centre));
            });
        }

        this.initSelect2();
    }

    static initSelect2() {

        $('#categorieId, #centres').each(function () {

            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }

        });

        $('#categorieId').select2({
            placeholder: "Sélection catégorie",
            width: '100%',
            allowClear: true,
            minimumResultsForSearch: 0
        });

        $('#centres').select2({
            placeholder: "Sélection centres",
            width: '100%',
            allowClear: true,
            minimumResultsForSearch: 0
        });
    }


    static async afficherExamens(id_concours, nomConcours) {

        const token = AdminController.getToken();

        const res = await ExamenModel.getExamensByConcours(
            id_concours,
            token
        );

        if (!res.ok) {

            Swal.fire(
                "Erreur",
                res.data?.error || "Impossible de charger les examens",
                "error"
            );

            return;
        }

        const examens = res.data.data || [];

        document.getElementById("titreModalExamens").textContent =
            "Examens - " + nomConcours;

        const tbody = document.getElementById("tbodyExamens");

        tbody.innerHTML = "";

        if (examens.length === 0) {

            tbody.innerHTML = `
            <tr>
                <td colspan="7" class="text-center">
                    Aucun examen programmé pour ce concours
                </td>
            </tr>
        `;

        } else {

            examens.forEach((examen, index) => {

                const date = examen.date_examen
                    ? examen.date_examen.split("T")[0]
                    : "-";

                const heure = examen.heure
                    ? examen.heure.substring(11, 16)
                    : "-";

                tbody.innerHTML += `
                <tr>

                    <td class="text-center">
                        ${index + 1}
                    </td>

                    <td class="text-center">
                        ${examen.intitule || "-"}
                    </td>

                    <td class="text-center">
                        ${examen.type_examen || "-"}
                    </td>

                    <td class="text-center">
                        ${examen.coefficient ?? "-"}
                    </td>

                    <td class="text-center">
                        ${date}
                    </td>

                    <td class="text-center">
                        ${heure}
                    </td>

                    <td class="text-center">
                        ${examen.lieu || "-"}
                    </td>

                </tr>
            `;
            });
        }

        const modal = new bootstrap.Modal(
            document.getElementById("modalExamens")
        );

        modal.show();
    }

}
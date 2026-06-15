import InscriptionModel from "../models/InscriptionModel.js";
import CandidatModel from "../models/CandidatModel.js";
import CentreModel from "../models/CentreModel.js";
import ConcoursModel from "../models/ConcoursModel.js";
import AdminController from "./AdminController.js";

export default class InscriptionController {

    static initInscriptionConcours() {

        const form = document.getElementById("formInscriptionConcours");

        if (!form) return;

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const token = AdminController.getToken();

            const id_candidat = document.getElementById("id_candidat").value;
            const id_concours = document.getElementById("id_concours").value;
            const id_centre = document.getElementById("id_centre").value;

            if (!id_candidat || !id_concours || !id_centre) {

                Swal.fire(
                    "Erreur",
                    "Tous les champs sont obligatoires",
                    "error"
                );

                return;
            }

            const data = {
                id_candidat: document.getElementById("id_candidat").value,
                id_concours: Number(id_concours),
                id_centre: Number(id_centre)
            };

            console.log("DATA INSCRIPTION :", data);

            const res = await InscriptionModel.inscrireConcours(token, data);

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data.error || "Erreur lors de l'inscription",
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

            $("#ajouter_inscription").modal("hide");

        });
    }

    static async loadConcours() {

        const token = AdminController.getToken();

        const res = await ConcoursModel.getAllConcours(token);

        const select = $("#id_concours");

        select.empty();

        select.append(
            `<option value="">Sélectionnez un concours</option>`
        );

        res.data.data.forEach(concours => {

            select.append(`
            <option value="${concours.id_concours}">
                ${concours.nom}
            </option>
        `);
        });

        select.select2({
            dropdownParent: $("#ajouter_inscription"),
            width: "100%",
            placeholder: "Sélectionnez un concours"
        });
    }

    static async loadCandidats() {

        const token = AdminController.getToken();

        const res = await CandidatModel.getAllCandidats(token);

        console.log("CANDIDATS :", res);

        const select = $("#id_candidat");

        select.empty();

        select.append(`<option value="">Sélectionnez un candidat</option>`);
        console.log("Premier candidat :", res.data.candidat[0]);
        res.data.candidat.forEach(c => {

            select.append(`
            <option value="${c.id_candidat}">
                ${c.nom} ${c.prenom}
            </option>
        `);
        });

        select.select2({
            dropdownParent: $("#ajouter_inscription"),
            width: "100%",
            placeholder: "Sélectionnez un candidat"
        });
    }

    static async loadCentres() {

        const token = AdminController.getToken();

        const res = await CentreModel.getAllCentres(token);

        const select = $("#id_centre");

        select.empty();

        select.append(
            `<option value="">Sélectionnez un centre</option>`
        );

        res.data.data.forEach(centre => {

            select.append(`
            <option value="${centre.id_centre}">
                ${centre.nom}
            </option>
        `);
        });

        select.select2({
            dropdownParent: $("#ajouter_inscription"),
            width: "100%",
            placeholder: "Sélectionnez un centre"
        });
    }

    static async loadInscriptions() {

        const token = AdminController.getToken();
        const res = await InscriptionModel.getAllInscriptions(token);

        console.log("INSCRIPTIONS :", res);

        const tbody = document.querySelector("#inscriptionTable tbody");
        tbody.innerHTML = "";

        const data = Object.values(res.data.data);

        data.forEach((item, index) => {

            const preview = item.inscriptions
                .slice(0, 2)
                .map(i => `
                <div>
                    <b>${i.concours.nom}</b>
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
                    ${item.inscriptions.length > 2
                    ? `<span class="badge badge-info">+${item.inscriptions.length - 2} autres</span>`
                    : ""
                }
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm btn-detail-delete"
                        data-id="${item.candidat.id_candidat}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>


                <td class="text-center">
                    <button class="btn btn-info btn-sm btn-detail-candidat"
                        data-id="${item.candidat.id_candidat}">
                        <i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
        `;
        });

        this.initDataTable();
    }

    static initDataTable() {

        if ($.fn.DataTable.isDataTable("#inscriptionTable")) {
            $("#inscriptionTable").DataTable().destroy();
        }

        $("#inscriptionTable").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
            }
        });
    }

    static initEvents() {

        document.addEventListener("click", async (e) => {

            // ===== DETAIL CANDIDAT =====
            const btnDetail = e.target.closest(".btn-detail-candidat");

            if (btnDetail) {
                await this.showDetailCandidat(btnDetail.dataset.id);
                return;
            }

            // ===== EDIT INSCRIPTION =====
            const btnEdit = e.target.closest(".btn-edit-inscription");

            if (btnEdit) {
                await this.openEditModal(btnEdit);
                return;
            }
        });


        document.getElementById("btnSaveInscription")
            .addEventListener("click", async () => {
                await this.saveInscription();
            });
    }

    static async showDetailCandidat(idCandidat) {

        const token = AdminController.getToken();

        const res = await InscriptionModel.getAllInscriptions(token);

        const candidats = Object.values(res.data.data);

        const candidat = candidats.find(
            c => c.candidat.id_candidat === idCandidat
        );

        if (!candidat) {
            Swal.fire("Erreur", "Candidat introuvable", "error");
            return;
        }

        const details = await Promise.all(
            candidat.inscriptions.map(ins =>
                InscriptionModel.detailInscription(token, ins.id_inscription)
            )
        );

        const concoursHTML = details.map(r => {

            const d = r.data.data;
            console.log("DETAIL INSCRIPTION", d);

            return `
            <tr>
                <td>${d.concours.nom}</td>
                <td>${d.concours.categorie?.libelle || "-"}</td>
                <td>${d.centre.nom}</td>
                <td>${d.statut_inscription}</td>
                <td>${new Date(d.date_inscription).toLocaleDateString()}</td>

                <td>
                    <button class="btn btn-warning btn-sm btn-edit-inscription"
                        data-id="${d.id_inscription}"
                        data-statut="${d.statut_inscription}"
                        data-centre="${d.centre.id_centre}">
                        <i class="fa fa-edit"></i>
                    </button>
                </td>

                <td>

                    <button
                        class="btn btn-danger btn-sm btn-delete-inscription"
                        data-id="${d.id_inscription}">
                        <i class="fa fa-trash"></i>
                    </button>

                </td>
            </tr>
        `;
        }).join("");

        document.getElementById("detailContent").innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nom :</strong> ${candidat.candidat.nom}</p>
                <p><strong>Prénom :</strong> ${candidat.candidat.prenom}</p>
                <p><strong>Email :</strong> ${candidat.candidat.email}</p>
                <p><strong>Téléphone :</strong> ${candidat.candidat.telephone || '-'}</p>
            </div>

             <div class="col-md-6">

                <p>
                    <strong>Type :</strong>
                    ${candidat.candidat.type_candidat || '-'}
                </p>

                <p>
                <strong>Statut :</strong>
                    ${candidat.candidat.statut_compte || '-'}
                </p>

                <p>
                    <strong>CNIB :</strong>
                    ${candidat.candidat.numero_cnib || '-'}
                </p>

                <p>
                    <strong>Lieu naissance :</strong>
                    ${candidat.candidat.lieu_naissance || '-'}
                </p>

         </div>

        </div>

        <hr>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Concours</th>
                    <th>Catégorie</th>
                    <th>Centre</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>${concoursHTML}</tbody>
        </table>
    `;

        $("#detailInscriptionModal").modal("show");

    }

    static async openEditModal(btn) {

        const idInscription = btn.dataset.id;
        const statut = btn.dataset.statut;
        const idCentre = btn.dataset.centre;

        console.log({
            idInscription,
            statut,
            idCentre
        });

        $("#edit_id_inscription").val(idInscription);

        // statut
        $("#edit_statut").val(statut);

        const token = AdminController.getToken();
        const centres = await CentreModel.getAllCentres(token);

        const selectCentre = $("#edit_centre");

        selectCentre.empty();

        centres.data.data.forEach(c => {

            selectCentre.append(`
            <option value="${c.id_centre}">
                ${c.nom}
            </option>
        `);
        });

        // Préselection du centre
        selectCentre.val(String(idCentre)).trigger("change");

        $("#editInscriptionModal").modal("show");
    }


    static async saveInscription() {

        const token = AdminController.getToken();

        const id_inscription = $("#edit_id_inscription").val();
        const status_inscriptions = $("#edit_statut").val();
        const id_centre = $("#edit_centre").val();

        await InscriptionModel.updateStatut(token, {
            id_inscription,
            status_inscriptions
        });

        await InscriptionModel.updateCentre(token, {
            id_inscription,
            id_centre
        });

        Swal.fire("Succès", "Modification enregistrée", "success");

        $("#editInscriptionModal").modal("hide");

        await this.loadInscriptions();
    }

    static initDeleteInscription() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest(".btn-delete-inscription");
            if (!btn) return;
            console.log("BOUTON CLIQUÉ");
            const id_inscription = btn.dataset.id;
            console.log("ID =", id_inscription);

            const result = await Swal.fire({
                title: "Supprimer l'inscription ?",
                text: "Cette action est irréversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui",
                cancelButtonText: "Annuler"
            });

            if (!result.isConfirmed) return;

            try {

                const token = AdminController.getToken();

                const res = await InscriptionModel.deleteInscription(
                    token,
                    id_inscription
                );
                console.log("REPONSE API :", res);

                if (!res.ok) {

                    Swal.fire(
                        "Erreur",
                        res.data.error || "Suppression impossible",
                        "error"
                    );

                    return;
                }

                Swal.fire(
                    "Succès",
                    "Inscription supprimée avec succès",
                    "success"
                );

                $("#detailInscriptionModal").modal("hide");

                await InscriptionController.loadInscriptions();

            } catch (error) {

                console.error(error);

                Swal.fire(
                    "Erreur",
                    "Une erreur est survenue",
                    "error"
                );
            }
        });
    }


    static async loadCentresByConcours(id_concours) {

        const token = AdminController.getToken();

        const res =
            await InscriptionModel.getCentresByConcours(
                token,
                id_concours
            );

        const select = $("#id_centre");

        select.empty();

        select.append(
            `<option value="">Sélectionnez un centre</option>`
        );

        res.data.forEach(centre => {

            select.append(`
            <option value="${centre.id_centre}">
                ${centre.nom}
            </option>
        `);

        });

        select.trigger("change.select2");
    }


}

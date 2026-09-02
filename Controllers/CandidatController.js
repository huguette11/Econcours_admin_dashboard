import CandidatModel from "../models/CandidatModel.js";
import CentreModel from "../models/CentreModel.js";
import ConcoursModel from "../models/ConcoursModel.js";
import AdminController from "./AdminController.js";

export default class CandidatController {

    static async getAll() {

        const token = AdminController.getToken();

        if (!token) {
            console.warn("Aucun token admin");
            return [];
        }

        const res = await CandidatModel.getAllCandidats(token);

        console.log("REPONSE API :", res);

        if (!res.ok) {
            console.log(res.data);
            Alert.error("Erreur chargement candidats");
            return [];
        }

        // CAS 1 : API retourne directement un tableau
        if (Array.isArray(res.data)) {
            return res.data;
        }

        // CAS 2 : API retourne { data: [...] }
        if (Array.isArray(res.data.data)) {
            return res.data.data;
        }

        // CAS 3 : API retourne { candidat: [...] }
        if (Array.isArray(res.data.candidat)) {
            return res.data.candidat;
        }

        return [];
    }

    static async initDataTable() {

        const tbody = document.getElementById("candidatTableBody");

        if (!tbody) {
            console.error("tbody introuvable");
            return;
        }

        const data = await this.getAll();

        console.log("DATA API :", data);

        const candidats = data;

        console.log("LISTE CANDIDATS :", candidats);

        tbody.innerHTML = "";

        candidats.forEach((item, index) => {

            const candidat = item;

            tbody.innerHTML += `
<tr>
    <td class="text-center">${index + 1}</td>
    <td class="text-center">${candidat.nom}</td>
    <td class="text-center">${candidat.prenom}</td>
    <td class="text-center">${candidat.numero_cnib}</td>
    <td class="text-center">${candidat.telephone}</td>
    <td class="text-center">${candidat.email}</td>
    <td class="text-center">${candidat.type_candidat}</td>

    <td class="text-center">
       <button class="btn btn-warning btn-sm edit-candidat"
    data-id="${candidat.id_candidat}"
    data-email="${candidat.email || ''}"
    data-nom-jeune-fille="${candidat.nom_jeune_fille || ''}"
    data-emploi="${candidat.emploi || ''}"
    data-ministere="${candidat.ministere || ''}"
    data-matricule="${candidat.matricule || ''}"
>
    <i class="fa fa-edit"></i>
</button>
    </td>

<td class="text-center">
    <button
        class="btn btn-danger btn-sm delete-candidat"
        data-id="${candidat.id_candidat}"
    >
        <i class="fa fa-trash"></i>
    </button>
    </td>

    <td class="text-center">

    <button
        class="btn btn-info btn-sm detail-candidat"
        data-id="${candidat.id_candidat}"
    >
        <i class="fa fa-eye"></i>
    </button>

    </td>
    </tr>
        `;
        });

        $('#dataTable').DataTable({
            destroy: true,
            pageLength: 10,

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

    }


    static initDeleteButtons() {

        document.addEventListener("click", async (e) => {

            const button = e.target.closest(".delete-candidat");

            if (!button) return;

            const id = button.dataset.id;

            const confirm = await Swal.fire({
                title: "Supprimer ?",
                text: "Cette action est irréversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui",
                cancelButtonText: "Annuler"
            });

            if (!confirm.isConfirmed) return;

            const token = AdminController.getToken();

            const res = await CandidatModel.DeleteCandidat(token, id);

            console.log(res);

            if (!res?.ok) {
                Swal.fire("Erreur", "Suppression impossible", "error");
                return;
            }

            Swal.fire("Succès", res.data?.message || "OK", "success");

            // reload tableau
            await this.initDataTable();

        });
    }

    static initEditModal() {

        document.addEventListener("click", (e) => {

            const btn = e.target.closest(".edit-candidat");
            if (!btn) return;

            // remplir modal
            document.getElementById("id_candidat").value = btn.dataset.id;
            document.getElementById("email_modif").value = btn.dataset.email;
            document.getElementById("nom_jeune_fille_modif").value = btn.dataset.nomJeuneFille;
            document.getElementById("emploi_modif").value = btn.dataset.emploi;
            document.getElementById("ministere_modif").value = btn.dataset.ministere;
            document.getElementById("matricule_modif").value = btn.dataset.matricule;

            // ouvrir modal bootstrap
            $("#modifier_candidat").modal("show");

        });

    }

    static initEditSubmit() {

        document.querySelector("#modifier_candidat form")
            .addEventListener("submit", async (e) => {

                e.preventDefault();

                const id = document.getElementById("id_candidat").value;

                const data = {
                    email: document.getElementById("email_modif").value,
                    nom_jeune_fille: document.getElementById("nom_jeune_fille_modif").value,
                    mot_de_passe: document.getElementById("mot_de_passe_modif").value,
                    emploi: document.getElementById("emploi_modif").value,
                    ministere: document.getElementById("ministere_modif").value,
                    matricule: document.getElementById("matricule_modif").value,
                };

                const token = AdminController.getToken();
                const res = await CandidatModel.updateCandidat(token, id, data);

                if (!res.ok) {

                    Swal.fire(
                        "Erreur",
                        res.data?.error || "Modification échouée",
                        "error"
                    );
                    return;

                }

                Swal.fire(
                    "Succès",
                    res.data?.message || "Candidat modifié",
                    "success"
                );

                // fermer modal
                $("#modifier_candidat").modal("hide");

                // refresh datatable SANS reload page
                await this.initDataTable();

            });

    }


    static initDetails() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest(".detail-candidat");

            if (!btn) return;

            const id = btn.dataset.id;

            const token = AdminController.getToken();

            const res = await CandidatModel.getDetailCandidat(token, id);

            console.log("DETAIL RESPONSE :", res);

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data?.error || "Impossible de charger",
                    "error"
                );

                return;

            }

            const data = res.data.resp[0];

            const candidat = data.candidat;
            const inscriptions = data.inscription;

            let concoursHTML = "";

            // verifier inscriptions
            if (inscriptions.length === 0) {

                concoursHTML = `
<tr>
<td colspan="5" class="text-center">
Aucune inscription
</td>
</tr>
`;

            } else {

                inscriptions.forEach((inscription) => {

                    concoursHTML += `

<tr>

<td>
${inscription.concours.nom}
</td>

<td>
${inscription.concours.type}
</td>

<td>
${inscription.concours.categorie.libelle}
</td>

<td>
${inscription.paiement?.statut_paiement || 'NON PAYE'}
</td>

<td>
${new Date(
                        inscription.date_inscription
                    ).toLocaleDateString()}
</td>

</tr>

`;

                });

            }

            document.getElementById("detailContent").innerHTML = `

<div class="row">

<div class="col-md-6">

<p>
<strong>Nom :</strong>
${candidat.nom}
</p>

<p>
<strong>Prénom :</strong>
${candidat.prenom}
</p>

<p>
<strong>Email :</strong>
${candidat.email || '-'}
</p>

<p>
<strong>Téléphone :</strong>
${candidat.telephone}
</p>

<p>
<strong>Sexe :</strong>
${candidat.sexe}
</p>

</div>

<div class="col-md-6">

<p>
<strong>Type :</strong>
${candidat.type_candidat}
</p>

<p>
<strong>Statut :</strong>
${candidat.statut_compte}
</p>

<p>
<strong>CNIB :</strong>
${candidat.numero_cnib}
</p>

<p>
<strong>Lieu naissance :</strong>
${candidat.lieu_naissance}
</p>

<p>
<strong>Pays :</strong>
${candidat.pays_naissance}
</p>

</div>

</div>

<hr>

<h5>
Concours inscrits
</h5>
<div class="table-responsive">
<table class="table table-bordered table-striped">

<thead>

<tr>
<th>Concours</th>
<th>Type</th>
<th>Catégorie</th>
<th>Paiement</th>
<th>Date inscription</th>
</tr>

</thead>

<tbody>

${concoursHTML}

</tbody>

</table>
</div>

`;

            $("#detailCandidatModal").modal("show");

        });

    }

    // =========================
    // CREER CANDIDAT
    // =========================

    static async registerCandidat() {

        const form = document.getElementById("formCandidat");

        if (!form) return;

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const token = AdminController.getToken();

            const formData = new FormData(form);

            const data = Object.fromEntries(formData.entries());

            console.log("DATA ENVOYÉE :", data);

            const res = await CandidatModel.createCandidat(token, data);

            if (!res.ok) {
                Alert.error(res.data.error || "Erreur création");
                return;
            }

            Alert.success(res.data.message || "Candidat créé avec succès");

            // fermer modal
            $('#ajouter_candidat').modal('hide');

            // reset form
            form.reset();

            // reload datatable
            await this.initDataTable();
        });
    }
}
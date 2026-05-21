// pages/assets/js/candidat.js

import CandidatController from "../../../Controllers/CandidatController.js";

async function chargerCandidats() {

    const candidats = await CandidatController.getAll();

    const tbody = document.querySelector("#dataTable tbody");

    tbody.innerHTML = "";

    candidats.forEach((candidat, index) => {

        tbody.innerHTML += `
            <tr>

                <td class="text-center">
                    ${index + 1}
                </td>

                <td class="text-center">
                    ${candidat.nom || ""}
                </td>

                <td class="text-center">
                    ${candidat.prenom || ""}
                </td>

                <td class="text-center">
                    ${candidat.nom_jeune_fille || ""}
                </td>

                <td class="text-center">
                    ${candidat.sexe || ""}
                </td>

                <td class="text-center">
                    ${candidat.date_naissance || ""}
                </td>

                <td class="text-center">
                    ${candidat.lieu_naissance || ""}
                </td>

                <td class="text-center">
                    ${candidat.pays_naissance || ""}
                </td>

                <td class="text-center">
                    ${candidat.numero_identite || ""}
                </td>

                <td class="text-center">
                    ${candidat.date_delivrance || ""}
                </td>

                <td class="text-center">
                    ${candidat.telephone || ""}
                </td>

                <td class="text-center">
                    ${candidat.email || ""}
                </td>

                <td class="text-center">
                    ${candidat.emploi || ""}
                </td>

                <td class="text-center">
                    ${candidat.matricule || ""}
                </td>

                <td class="text-center">
                    ${candidat.ministere || ""}
                </td>

                <td class="text-center">
                    ${candidat.type_candidat || ""}
                </td>

                <td class="text-center">
                    <button 
                        class="btn btn-warning btn-sm btn-edit"
                        data-id="${candidat.id_candidat}"
                    >
                        <i class="fa fa-edit"></i>
                    </button>
                </td>

                <td class="text-center">
                    <button 
                        class="btn btn-danger btn-sm btn-delete"
                        data-id="${candidat.id_candidat}"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;
    });

    ajouterEventsSuppression();
}

// ==========================
// SUPPRESSION
// ==========================
function ajouterEventsSuppression() {

    const boutons = document.querySelectorAll(".btn-delete");

    boutons.forEach((btn) => {

        btn.addEventListener("click", async function () {

            const id = this.dataset.id;

            const confirmation = confirm(
                "Voulez-vous supprimer ce candidat ?"
            );

            if (!confirmation) return;

            const deleted = await CandidatController.delete(id);

            if (deleted) {

                alert("Candidat supprimé");

                chargerCandidats();
            }
        });
    });
}

// ==========================
// LANCEMENT
// ==========================
chargerCandidats();
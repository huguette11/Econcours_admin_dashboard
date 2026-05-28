// pages/assets/js/concours.js

import ConcoursController from "../../../Controllers/ConcoursController.js";

document.addEventListener("DOMContentLoaded", async () => {

    const tbody = document.querySelector("#dataTable tbody");

    try {

        // Charger concours
        const response = await ConcoursController.getAll();

        

        // Si API retourne { ok:true, data:[...] }
        const concours = response.data || response;

        tbody.innerHTML = "";

        // Vérification
        if (!Array.isArray(concours)) {

            tbody.innerHTML = `
                <tr>
                    <td colspan="12" class="text-center text-danger">
                        Erreur format données
                    </td>
                </tr>
            `;

            return;
        }

        // Affichage
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
                        ${item.frais_inscription || ""}
                    </td>

                    <td class="text-center">
                        ${item.nombre_postes || ""}
                    </td>

                    <td class="text-center">
                        ${item.annee || ""}
                    </td>

                    <td class="text-center">
                        ${item.date_debut || ""}
                    </td>

                    <td class="text-center">
                        ${item.date_fin || ""}
                    </td>

                    <td class="text-center">
                        ${item.statut_concours || ""}
                    </td>

                    <td class="text-center">
                        <button 
                            class="btn btn-warning btn-sm"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>

                    <td class="text-center">
                        <button 
                            class="btn btn-danger btn-sm"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>

                </tr>
            `;
        });

        // Initialiser DataTable
        $('#dataTable').DataTable();

    } catch (error) {

        console.error(error);

        tbody.innerHTML = `
            <tr>
                <td colspan="12" class="text-center text-danger">
                    Erreur chargement concours
                </td>
            </tr>
        `;
    }

});
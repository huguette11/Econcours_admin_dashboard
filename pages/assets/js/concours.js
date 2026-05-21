import ConcoursController from "../../../Controllers/ConcoursController.js";

document.addEventListener("DOMContentLoaded", async () => {

    const token = localStorage.getItem("admin_token");

    if (!token) {
        window.location.href = "../../login.php";
        return;
    }

    const tbody = document.querySelector("#dataTable tbody");

    tbody.innerHTML = `
        <tr>
            <td colspan="12" class="text-center">
                Chargement...
            </td>
        </tr>
    `;

    const concours = await ConcoursController.getAll();

    tbody.innerHTML = "";

    if (!concours || concours.length === 0) {

        tbody.innerHTML = `
            <tr>
                <td colspan="12" class="text-center">
                    Aucun concours trouvé
                </td>
            </tr>
        `;

        return;
    }

    concours.forEach((concour, index) => {

        tbody.innerHTML += `
            <tr>

                <td class="text-center">
                    ${index + 1}
                </td>

                <td class="text-center">
                    ${concour.nom}
                </td>

                <td class="text-center">
                    ${concour.type_concours}
                </td>

                <td class="text-center">
                    ${concour.description}
                </td>

                <td class="text-center">
                    ${concour.frais_inscription}
                </td>

                <td class="text-center">
                    ${concour.nombre_poste}
                </td>

                <td class="text-center">
                    ${concour.annee}
                </td>

                <td class="text-center">
                    ${concour.date_debut}
                </td>

                <td class="text-center">
                    ${concour.date_fin}
                </td>

                <td class="text-center">
                    ${
                        concour.statut === "ACTIF"
                        ? `<span class="badge badge-success">ACTIF</span>`
                        : `<span class="badge badge-danger">INACTIF</span>`
                    }
                </td>

                <td class="text-center">
                    <button 
                        class="btn btn-warning btn-sm btn-edit"
                        data-id="${concour.id_concours}"
                    >
                        <i class="fa fa-edit"></i>
                    </button>
                </td>

                <td class="text-center">
                    <button 
                        class="btn btn-danger btn-sm btn-delete"
                        data-id="${concour.id_concours}"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                </td>

            </tr>
        `;
    });

    // SUPPRESSION
    document.querySelectorAll(".btn-delete").forEach(button => {

        button.addEventListener("click", async () => {

            const id = button.dataset.id;

            const confirmation = confirm(
                "Voulez-vous supprimer ce concours ?"
            );

            if (!confirmation) return;

            const deleted = await ConcoursController.delete(id);

            if (deleted) {

                alert("Concours supprimé");

                location.reload();
            }
        });

    });

});
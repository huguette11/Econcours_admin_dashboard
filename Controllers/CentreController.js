import CentreModel from "../models/CentreModel.js";
import AdminController from "./AdminController.js";

export default class CentreController {

    static initCreateCentre() {

        const form = document.getElementById("formAjoutCentre");

        if (!form) return;

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const token = AdminController.getToken();

            const data = {
                nom: document.getElementById("nom").value
            };

            const res = await CentreModel.createCentre(
                token,
                data
            );

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data.error || "Erreur création centre",
                    "error"
                );

                return;
            }

            Swal.fire(
                "Succès",
                "Centre créé avec succès",
                "success"
            );

            form.reset();

            $("#ajouter_centre").modal("hide");

            this.initDataTable();
        });
    }

    static async getAll() {

        const token = AdminController.getToken();

        const res = await CentreModel.getAllCentres(token);

        if (!res.ok) {

            Swal.fire(
                "Erreur",
                "Impossible de charger les centres",
                "error"
            );

            return [];
        }

        return res.data.data;
    }

    static async initDataTable() {

        const tbody = document.getElementById("centreTableBody");

        if (!tbody) return;

        const centres = await this.getAll();

        tbody.innerHTML = "";

        centres.forEach((centre, index) => {

            tbody.innerHTML += `
            <tr>

                <td class="text-center">
                    ${index + 1}
                </td>

                <td class="text-center">
                    ${centre.nom}
                </td>

                <td class="text-center">
                    <button
                        class="btn btn-warning btn-sm btn-edit"
                        data-id="${centre.id_centre}"
                        data-nom="${centre.nom}"
                    >
                        <i class="fa fa-edit"></i>
                    </button>
                </td>

                <td class="text-center">

                    <button
                        class="btn btn-danger btn-sm btn-delete"
                        data-id="${centre.id_centre}"
                    >
                        <i class="fa fa-trash"></i>
                    </button>

                </td>

            </tr>
        `;
        });

        if ($.fn.DataTable.isDataTable("#dataTable")) {
            $("#dataTable").DataTable().destroy();
        }

        $("#dataTable").DataTable({
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
    }

    static initEditCentre() {

        const form = document.getElementById("formUpdateCentre");

        if (!form) return;

        document.addEventListener("click", (e) => {

            const btn = e.target.closest(".btn-edit");

            if (!btn) return;

            document.getElementById("id_centre_modif").value =
                btn.dataset.id;

            document.getElementById("nom_centre_modif").value =
                btn.dataset.nom;

            $("#modifier_centre").modal("show");
        });

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const token = AdminController.getToken();

            const id_centre =
                document.getElementById("id_centre_modif").value;

            const data = {
                nom: document.getElementById("nom_centre_modif").value
            };

            const res = await CentreModel.updateCentre(
                id_centre,
                token,
                data
            );

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data.error || "Erreur modification",
                    "error"
                );

                return;
            }

            Swal.fire(
                "Succès",
                res.data.message,
                "success"
            );

            $("#modifier_centre").modal("hide");

            await this.initDataTable();
        });
    }

    static initDeleteCentre() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest(".btn-delete");
            if (!btn) return;

            const id = btn.dataset.id;

            const token = AdminController.getToken();

            const confirm = await Swal.fire({
                title: "Confirmer suppression ?",
                text: "Cette action est irréversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui supprimer"
            });

            if (!confirm.isConfirmed) return;

            const res = await CentreModel.deleteCentre(id, token);

            if (!res.ok) {

                Swal.fire("Erreur", res.data.error, "error");
                return;
            }

            Swal.fire("Succès", res.data.message, "success");

            await this.initDataTable();
        });
    }
}

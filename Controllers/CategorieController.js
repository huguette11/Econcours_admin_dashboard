import CategorieModel from "../models/CategorieModel.js";
import AdminController from "./AdminController.js";

export default class CategorieController {

    static async initDataTable() {

        const token = AdminController.getToken();

        const res = await CategorieModel.getAllCategories(token);

        console.log("CATEGORIES :", res);

        if (!res.ok) {

            Swal.fire(
                "Erreur",
                res.data.error || "Impossible de charger les catégories",
                "error"
            );

            return;
        }

        const categories = res.data.data;

        const tbody = document.querySelector("#dataTable tbody");

        tbody.innerHTML = "";

        categories.forEach((categorie, index) => {

            tbody.innerHTML += `
            
                <tr>

                    <td class="text-center">${index + 1}</td>

                    <td class="text-center">
                        ${categorie.libelle}
                    </td>

                    <td class="text-center">
                        ${categorie.description || "-"}
                    </td>

                    <td class="text-center">

                        <button 
                            class="btn btn-warning btn-sm edit-categorie"
                            data-id="${categorie.id}"
                            data-libelle="${categorie.libelle}"
                            data-description="${categorie.description || ''}"
                        >
                            <i class="fa fa-edit"></i>
                        </button>

                    </td>

                    <td class="text-center">

                        <button 
                            class="btn btn-danger btn-sm delete-categorie"
                            data-id="${categorie.id}"
                        >
                            <i class="fa fa-trash"></i>
                        </button>

                    </td>

                </tr>
            `;
        });

        if ($.fn.DataTable.isDataTable("#dataTable")) {
            $('#dataTable').DataTable().destroy();
        }

        $('#dataTable').DataTable({
            pageLength: 10,
            responsive: true
        });
    }

    static initCreateCategorie() {

        const form = document.getElementById("formAjoutCategorie");

        if (!form) return;

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const token = AdminController.getToken();

            const data = {
                libelle: document.getElementById("libelle").value,
                description: document.getElementById("description").value
            };

            const res = await CategorieModel.createCategorie(token, data);

            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data.error || res.data.message || "Erreur création catégorie",
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

            $("#ajouter_categorie").modal("hide");

            this.initDataTable();
        });
    }

    static initEditButtons() {

        document.addEventListener("click", (e) => {

            const btn =
                e.target.closest(".edit-categorie");

            if (!btn) return;

            document.getElementById("id_categorie").value =
                btn.dataset.id;

            document.getElementById("libelle_modif").value =
                btn.dataset.libelle;

            document.getElementById("description_modif").value =
                btn.dataset.description;

            $("#modifier_categorie").modal("show");
        });
    }

    static initUpdateCategorie() {

        const form =
            document.getElementById(
                "formModificationCategorie"
            );

        if (!form) return;

        form.addEventListener(
            "submit",
            async (e) => {

                e.preventDefault();

                const token =
                    AdminController.getToken();

                const id_categorie =
                    document.getElementById("id_categorie").value;

                const data = {
                    libelle:
                        document.getElementById("libelle_modif").value,

                    description:
                        document.getElementById("description_modif").value
                };

                console.log(data);

                const res = await CategorieModel.updateCategorie(
                    id_categorie,
                    data,
                    token
                );

                console.log(res);

                if (!res.ok) {

                    Swal.fire(
                        "Erreur",
                        res.data.error ||
                        "Modification impossible",
                        "error"
                    );

                    return;
                }

                Swal.fire(
                    "Succès",
                    res.data.message,
                    "success"
                );

                $("#modifier_categorie").modal("hide");

                this.initDataTable();
            }
        );
    }

}
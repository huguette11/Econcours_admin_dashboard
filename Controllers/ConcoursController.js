import ConcoursModel from "../models/ConcoursModel.js";
import AdminController from "./AdminController.js";

export default class ConcoursController {

    // =========================================
    // GET ALL
    // =========================================
    static async getAll(page = 1) {

        const token = AdminController.getToken();

        if (!token) {
            console.warn("Aucun token admin");
            return [];
        }

        const res = await ConcoursModel.getAllConcours(token, page);

        console.log("REPONSE API :", res);
        console.log("NOMBRE :", res.data.data.length);

        if (!res.ok) {
            alert("Erreur chargement concours");
            return [];
        }

        return res.data;
    }

    // =========================================
    // DATATABLE
    // =========================================
    static async initDataTable() {

        const tbody = document.getElementById("concoursTableBody");

        if (!tbody) {
            console.error("tbody concours introuvable");
            return;
        }

        const response = await this.getAll();

        const concours = response.data || [];

        console.log("LISTE CONCOURS :", concours);

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
                        ${item.frais_inscription || ""}
                    </td>

                    <td class="text-center">
                        ${item.annee || ""}
                    </td>

                    <td class="text-center">
                        ${item.date_debut?.split("T")[0] || ""}
                    </td>

                    <td class="text-center">
                        ${item.date_fin?.split("T")[0] || ""}
                    </td>

                    <td class="text-center">
                        ${item.statut_concours || ""}
                    </td>

                    <td class="text-center">
                        <button 
                            class="btn btn-warning btn-sm btn-edit"
                            data-id="${item.id_concours}"
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

                </tr>
            `;
        });

        // Destroy ancienne DataTable
        if ($.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable().destroy();
        }

        // Nouvelle DataTable
        $('#dataTable').DataTable({
            destroy: true,
            responsive: true,
            paging: true,
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            searching: true,
            ordering: true,
            info: true
        });

        // EVENTS
        this.initDeleteButtons();
        this.initEditButtons();
    }

    // =========================================
    // AJOUT
    // =========================================
    static async create(data) {
        console.log("DATA ENVOYEE :", data);

        const token = AdminController.getToken();

        const res = await ConcoursModel.createConcours(token, data);

        console.log("CREATE :", res);

        if (!res.ok) {
            alert(res.data.message || "Erreur création");
            return false;
        }

        alert("Concours ajouté");

        await this.initDataTable();

        return true;
    }

    // =========================================
    // MODIFICATION
    // =========================================
    static async update(id, data) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.updateConcours(token, id, data);

        console.log("UPDATE :", res);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification");
            return false;
        }

        alert("Concours modifié");

        await this.initDataTable();

        return true;
    }

    // =========================================
    // SUPPRESSION
    // =========================================
    static async delete(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.deleteConcours(token, id);

        console.log("DELETE :", res);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression");
            return false;
        }

        alert("Concours supprimé");

        await this.initDataTable();

        return true;
    }

    // =========================================
    // DETAIL
    // =========================================
    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.getDetailConcours(token, id);

        if (!res.ok) {
            alert("Erreur détail concours");
            return null;
        }

        return res.data;
    }

    // =========================================
    // DELETE BUTTONS
    // =========================================
    static initDeleteButtons() {

        const buttons = document.querySelectorAll(".btn-delete");

        buttons.forEach((btn) => {

            btn.addEventListener("click", async () => {

                const id = btn.dataset.id;

                const confirmDelete = confirm(
                    "Voulez-vous supprimer ce concours ?"
                );

                if (!confirmDelete) return;

                await this.delete(id);
            });
        });
    }

    // =========================================
    // EDIT BUTTONS
    // =========================================
    static initEditButtons() {

        const buttons = document.querySelectorAll(".btn-edit");

        buttons.forEach((btn) => {

            btn.addEventListener("click", async () => {

                const id = btn.dataset.id;

                const concours = await this.getDetail(id);

                console.log("DETAIL :", concours);

                // EXEMPLE
                // remplir modal ici

                alert("Modification concours ID : " + id);
            });
        });
    }

    // =========================================
    // SEARCH
    // =========================================
    static async search(query) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.searchConcours(token, query);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }

    // =========================================
    // SWITCH STATUS
    // =========================================
    static async switchStatus(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.switchStatus(token, id);

        if (!res.ok) {
            alert("Erreur changement statut");
            return false;
        }

        await this.initDataTable();

        return true;
    }
}
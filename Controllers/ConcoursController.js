import ConcoursModel from "../models/ConcoursModel.js";
import AdminController from "./AdminController.js";

export default class ConcoursController {

    // =========================
    // RECUPERER TOUS LES CONCOURS
    // =========================
    static async getAll(page = 1) {

        const token = AdminController.getToken();

        if (!token) {
            console.warn("Aucun token admin");
            return [];
        }

        const res = await ConcoursModel.getAllConcours(token, page);

        console.log("REPONSE API :", res);

        if (!res.ok) {
            alert("Erreur chargement concours");
            return [];
        }

        return res.data;
    }

    // =========================
    // DATATABLE
    // =========================
    static async initDataTable() {

        const tbody = document.getElementById("concoursTableBody");

        if (!tbody) {
            console.error("tbody introuvable");
            return;
        }

        const response = await this.getAll();

        console.log("CONCOURS :", response);

        // API = { page, total, data: [] }
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
                            data-id="${item.id_concours}"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>

                    <td class="text-center">
                        <button 
                            class="btn btn-danger btn-sm"
                            data-id="${item.id_concours}"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>

                </tr>
            `;
        });

        $('#dataTable').DataTable({
            destroy: true,
            pageLength: 10
        });
    }

    // =========================
    // DETAIL CONCOURS
    // =========================
    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.getDetailConcours(token, id);

        if (!res.ok) {
            alert("Erreur détail concours");
            return null;
        }

        return res.data;
    }

    // =========================
    // CREER CONCOURS
    // =========================
    static async create(data) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.createConcours(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création");
            return false;
        }

        return true;
    }

    // =========================
    // MODIFIER CONCOURS
    // =========================
    static async update(id, data) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.updateConcours(token, id, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification");
            return false;
        }

        return true;
    }

    // =========================
    // SUPPRIMER CONCOURS
    // =========================
    static async delete(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.deleteConcours(token, id);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression");
            return false;
        }

        return true;
    }

    // =========================
    // RECHERCHE
    // =========================
    static async search(query) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.searchConcours(token, query);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }

    // =========================
    // CHANGER STATUT
    // =========================
    static async switchStatus(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.switchStatus(token, id);

        if (!res.ok) {
            alert("Erreur changement statut");
            return false;
        }

        return true;
    }
}

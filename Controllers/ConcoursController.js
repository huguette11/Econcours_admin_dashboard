import ConcoursModel from "../models/ConcoursModel.js";
import AdminController from "./AdminController.js";

export default class ConcoursController {

    static async getAll(page = 1) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.getAllConcours(token, page);

        if (!res.ok) {
            alert("Erreur chargement concours");
            return [];
        }

        return res.data;
    }

    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.getDetailConcours(token, id);

        if (!res.ok) {
            alert("Erreur détail concours");
            return null;
        }

        return res.data;
    }

    static async create(data) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.createConcours(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création");
            return false;
        }

        return true;
    }

    static async update(id, data) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.updateConcours(token, id, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification");
            return false;
        }

        return true;
    }

    static async delete(id) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.deleteConcours(token, id);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression");
            return false;
        }

        return true;
    }

    static async search(query) {

        const token = AdminController.getToken();

        const res = await ConcoursModel.searchConcours(token, query);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }

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
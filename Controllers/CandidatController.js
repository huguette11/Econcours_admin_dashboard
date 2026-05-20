import CandidatModel from "../models/CandidatModel.js";
import AdminController from "./AdminController.js";

export default class CandidatController {

    static async getAll(page = 1) {

        const token = AdminController.getToken();

        const res = await CandidatModel.getAllCandidats(token, page);

        if (!res.ok) {
            alert("Erreur chargement candidats");
            return [];
        }

        return res.data;
    }

    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await CandidatModel.getDetailCandidat(token, id);

        if (!res.ok) {
            alert("Erreur détail candidat");
            return null;
        }

        return res.data;
    }

    static async search(query) {

        const token = AdminController.getToken();

        const res = await CandidatModel.searchCandidat(token, query);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }
}
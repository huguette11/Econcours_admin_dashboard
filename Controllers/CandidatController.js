// Controllers/CandidatController.js

import CandidatModel from "../models/CandidatModel.js";
import AdminController from "./AdminController.js";

export default class CandidatController {

    // =========================
    // CHARGER TOUS LES CANDIDATS
    // =========================
    static async getAll() {

        const token = AdminController.getToken();

        if (!token) {
            window.location.href = "../login.php";
            return [];
        }

        const res = await CandidatModel.getAllCandidats(token);

        if (!res.ok) {
            console.log(res.data);
            alert("Erreur chargement candidats");
            return [];
        }

        return res.data;
    }

    // =========================
    // DETAIL CANDIDAT
    // =========================
    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await CandidatModel.getDetailCandidat(token, id);

        if (!res.ok) {
            alert("Erreur détail candidat");
            return null;
        }

        return res.data;
    }

    // =========================
    // CREER CANDIDAT
    // =========================
    static async create(data) {

        const token = AdminController.getToken();

        const res = await CandidatModel.createCandidat(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création candidat");
            return false;
        }

        return true;
    }

    // =========================
    // MODIFIER CANDIDAT
    // =========================
    static async update(id, data) {

        const token = AdminController.getToken();

        const res = await CandidatModel.updateCandidat(token, id, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification candidat");
            return false;
        }

        return true;
    }

    // =========================
    // SUPPRIMER CANDIDAT
    // =========================
    static async delete(id) {

        const token = AdminController.getToken();

        const res = await CandidatModel.deleteCandidat(token, id);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression candidat");
            return false;
        }

        return true;
    }

    // =========================
    // RECHERCHE CANDIDAT
    // =========================
    static async search(query) {

        const token = AdminController.getToken();

        const res = await CandidatModel.searchCandidat(token, query);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }
}
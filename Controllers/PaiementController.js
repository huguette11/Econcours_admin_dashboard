import PaiementModel from "../models/PaiementModel.js";
import AdminController from "./AdminController.js";

export default class PaiementController {

    static async getAll(page = 1) {

        const token = AdminController.getToken();

        const res = await PaiementModel.getPaiements(token, page);

        if (!res.ok) {
            alert("Erreur chargement paiements");
            return [];
        }

        return res.data;
    }

    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await PaiementModel.getDetailPaiement(token, id);

        if (!res.ok) {
            alert("Erreur détail paiement");
            return null;
        }

        return res.data;
    }

    static async updateStatus(id, statut) {

        const token = AdminController.getToken();

        const res = await PaiementModel.updatePaiementStatus(
            token,
            id,
            statut
        );

        if (!res.ok) {
            alert(res.data.message || "Erreur mise à jour");
            return false;
        }

        return true;
    }
}
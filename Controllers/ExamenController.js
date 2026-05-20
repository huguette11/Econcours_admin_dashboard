import ExamenModel from "../models/ExamenModel.js";
import AdminController from "./AdminController.js";

export default class ExamenController {

    static async create(data) {

        const token = AdminController.getToken();

        const res = await ExamenModel.createExamen(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création examen");
            return false;
        }

        return true;
    }

    static async getByConcours(id_concours) {

        const token = AdminController.getToken();

        const res = await ExamenModel.getExamensByConcours(token, id_concours);

        if (!res.ok) {
            alert("Erreur chargement examens");
            return [];
        }

        return res.data;
    }

    static async getDetail(id_examen) {

        const token = AdminController.getToken();

        const res = await ExamenModel.getDetailExamen(token, id_examen);

        if (!res.ok) {
            alert("Erreur détail examen");
            return null;
        }

        return res.data;
    }

    static async update(id_examen, data) {

        const token = AdminController.getToken();

        const res = await ExamenModel.updateExamen(token, id_examen, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification examen");
            return false;
        }

        return true;
    }

    static async delete(id_examen) {

        const token = AdminController.getToken();

        const res = await ExamenModel.deleteExamen(token, id_examen);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression examen");
            return false;
        }

        return true;
    }

    static async uploadQuestion(formData) {

        const token = AdminController.getToken();

        const res = await ExamenModel.uploadQuestion(token, formData);

        if (!res.ok) {
            alert(res.data.message || "Erreur upload");
            return null;
        }

        return res.data;
    }
}
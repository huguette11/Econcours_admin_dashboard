import CategorieModel from "../models/CategorieModel.js";
import AdminController from "./AdminController.js";

export default class CategorieController {

    static async getAll() {

        const token = AdminController.getToken();

        const res = await CategorieModel.getCategories(token);

        if (!res.ok) {
            alert("Erreur chargement catégories");
            return [];
        }

        return res.data;
    }

    static async getCategorieConcours() {

        const token = AdminController.getToken();

        const res = await CategorieModel.getCategorieConcours(token);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }

    static async create(data) {

        const token = AdminController.getToken();

        const res = await CategorieModel.createCategorie(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création catégorie");
            return false;
        }

        return true;
    }

    static async update(id, data) {

        const token = AdminController.getToken();

        const res = await CategorieModel.updateCategorie(token, id, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification catégorie");
            return false;
        }

        return true;
    }

    static async delete(id) {

        const token = AdminController.getToken();

        const res = await CategorieModel.deleteCategorie(token, id);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression catégorie");
            return false;
        }

        return true;
    }
}
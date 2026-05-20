import CentreModel from "../models/CentreModel.js";
import AdminController from "./AdminController.js";

export default class CentreController {

    static async create(data) {

        const token = AdminController.getToken();

        const res = await CentreModel.createCentre(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création centre");
            return false;
        }

        return true;
    }
}
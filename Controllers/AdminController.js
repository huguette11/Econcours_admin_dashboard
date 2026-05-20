import AdminModel from "../models/AdminModel.js";

export default class AdminController {

    static getToken() {
        return localStorage.getItem("admin_token");
    }

    static saveToken(token) {
        localStorage.setItem("admin_token", token);
    }

    static logout() {
        localStorage.removeItem("admin_token");
        window.location.href = "login.php";
    }

    static checkAuth() {
        const token = this.getToken();

        if (!token) {
            window.location.href = "login.php";
        }

        return token;
    }

    static async login(email, password) {

        const res = await AdminModel.login({
            email,
            password
        });

        if (!res.ok) {
            alert(res.data.message || "Erreur connexion");
            return false;
        }

        this.saveToken(res.data.token);

        window.location.href = "dashboard.php";

        return true;
    }

    static async register(data) {

        const res = await AdminModel.register(data);

        if (!res.ok) {
            alert(res.data.message || "Erreur inscription");
            return false;
        }

        return true;
    }

    static async loadDashboard() {

        const token = this.checkAuth();

        const res = await AdminModel.getDashboard(token);

        if (!res.ok) {
            alert("Erreur chargement dashboard");
            return null;
        }

        return res.data;
    }
}
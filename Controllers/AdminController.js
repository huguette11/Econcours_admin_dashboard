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

    static initRegister() {

        const form = document.getElementById("registerForm");

        if (!form) return;

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const formData = new FormData(form);

            const data = {
                nom: formData.get("nom"),
                prenom: formData.get("prenom"),
                role: formData.get("role"),
                telephone: formData.get("telephone"),
                email: formData.get("email"),
                mot_de_passe: formData.get("mot_de_passe")
            };

            console.log("DATA ENVOYEES :", data);

            await this.register(data);

        });
    }

    static async register(data) {

        const res = await AdminModel.register(data);

        console.log("REPONSE REGISTER :", res);

        if (!res.ok) {

            alert(res.data.error || res.data.message || "Erreur inscription");

            return false;
        }

        alert(res.data.message);

        window.location.href = "../login.php";

        return true;
    }

    static initLogin() {

        const form = document.getElementById("loginForm");

        if (!form) return;

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const formData = new FormData(form);

            const email = formData.get("email");
            const password = formData.get("mot_de_passe");

            console.log("LOGIN DATA :", {
                email,
                password
            });

            await this.login(email, password);

        });
    }

    static async login(email, mot_de_passe) {

        const res = await AdminModel.login({
            email,
            mot_de_passe
        });

        if (!res.ok) {
            alert(res.data.error || res.data.message || "Erreur connexion");
            return false;
        }

        this.saveToken(res.data.token);

        window.location.href = "views/admin.php";

        return true;
    }

    static async GetAllConcours(req, res) {

    try {

        const concours = await Concours.findAll();

        res.json({
            ok: true,
            data: concours
        });

    } catch (error) {

        res.status(500).json({
            ok: false,
            message: error.message
        });
    }
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
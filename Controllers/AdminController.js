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

    // static async GetAllConcours(req, res) {

    //     try {

    //         const concours = await Concours.findAll();

    //         res.json({
    //             ok: true,
    //             data: concours
    //         });

    //     } catch (error) {

    //         res.status(500).json({
    //             ok: false,
    //             message: error.message
    //         });
    //     }
    // }

    static async loadDashboard() {

        const token = this.checkAuth();

        const res = await AdminModel.getDashboard(token);

        if (!res.ok) {
            alert("Erreur chargement dashboard");
            return null;
        }

        return res.data;
    }


    static async loadAdmins() {

        const token = AdminController.getToken();

        const res = await AdminModel.getAllAdmins(token);

        if (!res.ok) {
            console.error("Erreur admins :", res);
            return;
        }

        const admins = res.data.data;

        const tbody = document.querySelector("#adminTable tbody");
        tbody.innerHTML = "";

        admins.forEach((admin, index) => {
            console.log(admin);
            tbody.innerHTML += `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td>${admin.nom}</td>
                    <td>${admin.prenom}</td>
                    <td>${admin.email}</td>
                    <td>${admin.telephone || '-'}</td>
                    <td>${new Date(admin.date_creation).toLocaleDateString()}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm btn-edit-admin"
                            data-id="${admin.id_admin}">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm btn-delete-admin"
                            data-id="${admin.id}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        this.initDataTable();
    }

    static initDataTable() {

        if ($.fn.DataTable.isDataTable("#adminTable")) {
            $("#adminTable").DataTable().destroy();
        }

        $("#adminTable").DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
            }
        });
    }

    static initCreateAdmin() {

        const form = document.getElementById("adminForm");

        if (!form) {
            console.error("adminForm introuvable dans le DOM");
            return;
        }

        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const token = AdminController.getToken();

            const data = {
                nom: document.getElementById("nom").value,
                prenom: document.getElementById("prenom").value,
                email: document.getElementById("email").value,
                telephone: document.getElementById("telephone").value,
                mot_de_passe: document.getElementById("mot_de_passe").value,
                role: document.getElementById("role").value
            };

            const res = await AdminModel.registerAdmin(token, data);

            if (!res.ok) {
                Swal.fire("Erreur", "Création échouée", "error");
                return;
            }

            Swal.fire("Succès", "Admin créé avec succès", "success");
            form.reset();

            $("#ajouter_admin").modal("hide");

            this.initDataTable();
        });
    }

    static initDeleteAdmin() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest(".btn-delete-admin");

            if (!btn) return;

            const id_admin = btn.dataset.id;

            console.log("ID ADMIN =", id_admin);

            const result = await Swal.fire({
                title: "Supprimer cet administrateur ?",
                text: "Cette action est irréversible",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Supprimer",
                cancelButtonText: "Annuler"
            });

            if (!result.isConfirmed) return;

            const token = this.getToken();

            const res = await AdminModel.deleteAdmin(
                token,
                id_admin
            );

            if (!res.ok) {
                Swal.fire(
                    "Erreur",
                    res.data.error || "Suppression impossible",
                    "error"
                );
                return;
            }

            Swal.fire(
                "Succès",
                res.data.message,
                "success"
            );

            await this.loadAdmins();
        });
    }
}


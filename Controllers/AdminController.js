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

        // ADMIN
        console.log(res.data)
        localStorage.setItem(
            "admin",
            JSON.stringify(res.data.admin)
        );

        // localStorage.setItem(
        //     "id_admin",
        //     res.data.admin.id_admin
        // );

        window.location.href = "views/dashboard.php";

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
                    <td>${admin.role}</td>
                    <td>${admin.email}</td>
                    <td>${admin.telephone || '-'}</td>
                    <td>${new Date(admin.date_creation).toLocaleDateString()}</td>
                    <td class="text-center">
                        <button class="btn btn-warning btn-sm btn-update-admin"
                            data-id="${admin.id}"
                            data-nom="${admin.nom}"
                            data-prenom="${admin.prenom}"
                            data-role="${admin.role}">
                            
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

    static initEditAdmin() {

        document.addEventListener("click", (e) => {

            const btn = e.target.closest(".btn-update-admin");
            if (!btn) return;

            document.getElementById("edit_admin_id").value = btn.dataset.id;
            document.getElementById("edit_nom").value = btn.dataset.nom;
            document.getElementById("edit_prenom").value = btn.dataset.prenom;
            document.getElementById("edit_role").value = btn.dataset.role;

            $("#editAdminModal").modal("show");
        });
    }

    static initUpdateAdmin() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest("#btn-update-admin");
            if (!btn) return;

            e.preventDefault();

            const token = AdminController.getToken();

            const id_admin = document.getElementById("edit_admin_id").value;

            const data = {
                nom: document.getElementById("edit_nom").value,
                prenom: document.getElementById("edit_prenom").value,
                role: document.getElementById("edit_role").value
            };

            console.log("UPDATE DATA :", data);

            const res = await AdminModel.updateAdmin(token, id_admin, data);

            if (!res.ok) {
                Swal.fire("Erreur", res.data?.error || "Erreur update", "error");
                return;
            }

            Swal.fire("Succès", res.data.message, "success");

            $("#editAdminModal").modal("hide");

            await AdminController.loadAdmins();
        });
    }

    static initLogout() {

        document.addEventListener("click", (e) => {

            const btn = e.target.closest("#btnLogout");

            if (!btn) return;

            e.preventDefault();

            Swal.fire({
                title: "Déconnexion",
                text: "Voulez-vous vraiment vous déconnecter ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Oui",
                cancelButtonText: "Annuler"
            }).then((result) => {

                if (result.isConfirmed) {

                    localStorage.removeItem("token");
                    localStorage.removeItem("admin");

                    window.location.href = "../login.php";
                }

            });

        });
    }

    static async loadProfile() {

        const token = this.getToken();

        const id_admin = localStorage.getItem("id_admin");

        if (!id_admin) {
            Swal.fire("Erreur", "Administrateur introuvable", "error");
            return;
        }

        const res = await AdminModel.getProfile(
            token,
            id_admin
        );

        if (!res.ok) {
            Swal.fire("Erreur", res.data.error, "error");
            return;
        }

        const admin = res.data.data;

        // document.getElementById("profil_nom").textContent =
        //     admin.nom;

        // document.getElementById("profil_prenom").textContent =
        //     admin.prenom;

        // document.getElementById("profil_role").textContent =
        //     admin.role;
        
            

        const nom = admin.nom || "";
        const prenom = admin.prenom || "";

        // initiales
        const initials = (nom.charAt(0) + prenom.charAt(0)).toUpperCase();

        // avatar
        document.getElementById("profileAvatar").textContent = initials;

        // infos header
        document.getElementById("adminNomComplet").textContent = `${nom} ${prenom}`;
        document.getElementById("adminRole").textContent = admin.role;

        // champs profil
        document.getElementById("profil_nom").textContent = nom;
        document.getElementById("profil_prenom").textContent = prenom;
        document.getElementById("profil_email").textContent = admin.email;
        document.getElementById("profil_tel").textContent = admin.telephone || "-";
        document.getElementById("profil_role").textContent = admin.role;
    }
}


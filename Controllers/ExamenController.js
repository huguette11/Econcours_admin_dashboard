import ExamenModel from "../models/ExamenModel.js";
import AdminController from "./AdminController.js";
import ConcoursModel from "../models/ConcoursModel.js";

export default class ExamenController {

    // =========================================
    // INITIALISATION
    // =========================================

    static async init() {

        await this.loadConcours();

        this.initCreateExamen();

        this.getAll();

        this.initEditExamen();

        this.initDeleteExamen();

        this.initDataTable();

    }


    // =========================================
    // GET ALL EXAMENS
    // =========================================

    // static async getAll() {

    //     const token = AdminController.getToken();

    //     if (!token) {

    //         console.warn("Aucun token administrateur");

    //         return [];

    //     }

    //     const res = await ExamenModel.getAllExamens(token);

    //     if (!res.ok) {

    //         console.error(
    //             res.data?.error || "Erreur chargement examens"
    //         );

    //         Swal.fire({
    //             icon: "error",
    //             title: "Erreur",
    //             text: res.data?.error || "Impossible de charger les examens"
    //         });

    //         return [];

    //     }

    //     return res.data;

    // }

    static async getAll() {

        const token = AdminController.getToken();

        if (!token) {
            console.warn("Aucun token administrateur");
            return [];
        }

        const res = await ExamenModel.getAllExamens(token);

        console.log("Réponse API examens :", res);
        console.log("res.ok :", res.ok);
        console.log("res.data :", res.data);
        console.log("Type res.data :", typeof res.data);
        console.log("Est un tableau :", Array.isArray(res.data));

        if (!res.ok) {

            console.error(
                res.data?.error || "Erreur chargement examens"
            );

            Swal.fire({
                icon: "error",
                title: "Erreur",
                text: res.data?.error || "Impossible de charger les examens"
            });

            return [];
        }

        return res.data;
    }

    // =========================================
    // DATATABLE
    // =========================================

    static async initDataTable() {

        console.log("INITIALISATION DATATABLE EXAMENS");

        const tbody = document.getElementById("examenTableBody");

        if (!tbody) {

            console.error("tbody examens introuvable");

            return;

        }

        const examens = await this.getAll();

        // Backend : { data: examens }
        // const examens = response.data || [];

        console.log("LISTE EXAMENS :", examens);

        // Détruire l'ancienne DataTable
        if ($.fn.DataTable.isDataTable("#dataTable")) {

            $("#dataTable").DataTable().destroy();

        }


        // Vider le tableau
        tbody.innerHTML = "";


        examens.forEach((item, index) => {

            const date = item.date_examen
                ? item.date_examen.split("T")[0]
                : "-";


            // Formatage heure
            let heure = "-";

            if (item.heure) {

                const dateHeure = new Date(item.heure);

                heure = dateHeure.toLocaleTimeString(
                    "fr-FR",
                    {
                        hour: "2-digit",
                        minute: "2-digit"
                    }
                );

            }


            tbody.innerHTML += `

            <tr>

                <td class="text-center">
                    ${index + 1}
                </td>

                <td class="text-center">
                    ${date}
                </td>

                <td class="text-center">
                    ${heure}
                </td>

                <td class="text-center">
                    ${item.lieu || "-"}
                </td>

                <td class="text-center">
                    ${item.coefficient ?? "-"}
                </td>

                <td class="text-center">
                    ${item.intitule || "-"}
                </td>

                <td class="text-center">
                    ${item.type_examen || "-"}
                </td>

                <td class="text-center">

                   <button
                        class="btn btn-warning btn-sm btn-edit-examen"
                        data-id="${item.id_examen}"
                        data-intitule="${item.intitule || ""}"
                        data-type="${item.type_examen || ""}"
                        data-coefficient="${item.coefficient || ""}"
                        data-date="${item.date_examen?.split("T")[0] || ""}"
                        data-heure="${item.heure ? item.heure.substring(11, 16) : ""}"
                        data-lieu="${item.lieu || ""}">
                        
                        <i class="fa fa-edit"></i>
                    </button>

                </td>

                <td class="text-center">

                    <button
                        class="btn btn-danger btn-sm btn-delete-examen"
                        data-id="${item.id_examen}"
                        title="Supprimer">

                        <i class="fa fa-trash"></i>

                    </button>
                </td>

            </tr>

        `;

        });


        // Initialiser DataTable
        $("#dataTable").DataTable({

            responsive: true,

            paging: true,

            pageLength: 10,

            lengthMenu: [10, 25, 50, 100],

            searching: true,

            ordering: true,

            info: true,

            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json"
            },

            layout: {
                topStart: [
                    'pageLength',
                    {
                        buttons: ['copy', 'excel', 'csv', 'pdf']
                    }
                ],
                topEnd: 'search',

                bottomStart: 'info',
                bottomEnd: 'paging'
            }

        });

    }


    // =========================================
    // CHARGER LES CONCOURS
    // =========================================

    static async loadConcours() {

        const token = AdminController.getToken();

        const select = document.getElementById("id_concours");

        if (!select) return;

        const res = await ConcoursModel.getAllConcours(token);

        if (!res.ok) {

            console.error("Erreur chargement concours");

            return;
        }

        const concours = res.data.data || [];

        concours.forEach(c => {

            const option = document.createElement("option");

            option.value = c.id_concours;

            option.textContent = c.nom;

            select.appendChild(option);

        });

    }


    static initCreateExamen() {

        const form = document.getElementById("formExamen");

        if (!form) {
            console.error("Formulaire formExamen introuvable");
            return;
        }

        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            // Récupération des valeurs
            const intitule = document.getElementById("intitule").value.trim();

            const type_examen =
                document.getElementById("type_examen").value;

            const coefficient =
                document.getElementById("coefficient").value;

            const date_examen =
                document.getElementById("date_examen").value;

            const heure =
                document.getElementById("heure").value;

            const lieu =
                document.getElementById("lieu").value.trim();

            const id_concours =
                document.getElementById("id_concours").value;


            // Vérification
            console.log("INTITULE :", intitule);
            console.log("TYPE :", type_examen);
            console.log("COEFFICIENT :", coefficient);
            console.log("DATE :", date_examen);
            console.log("HEURE :", heure);
            console.log("LIEU :", lieu);
            console.log("CONCOURS :", id_concours);


            // Validation
            if (
                !intitule ||
                !type_examen ||
                !coefficient ||
                !date_examen ||
                !heure ||
                !lieu ||
                !id_concours
            ) {

                Swal.fire({
                    icon: "warning",
                    title: "Champs incomplets",
                    text: "Veuillez remplir tous les champs."
                });

                return;
            }


            const data = {

                intitule: intitule,

                type_examen: type_examen,

                coefficient: Number(coefficient),

                date_examen: date_examen,

                // Ton backend attend une date complète
                heure: `${date_examen}T${heure}:00`,

                lieu: lieu,

                id_concours: Number(id_concours)

            };


            console.log("DATA EXAMEN :", data);


            const token = AdminController.getToken();

            const res = await ExamenModel.createExamen(
                token,
                data
            );


            console.log("REPONSE API :", res);


            if (!res.ok) {

                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text:
                        res.data?.error ||
                        res.data?.message ||
                        "Impossible de créer l'examen"
                });

                return;
            }


            Swal.fire({
                icon: "success",
                title: "Succès",
                text: res.data.message
            });


            // Réinitialiser le formulaire
            form.reset();


            // Fermer le modal
            $("#ajouter_examen").modal("hide");


            // Recharger le DataTable
            await this.initDataTable();

        });

    }

    static initEditExamen() {

        const form = document.getElementById("formUpdateExamen");

        if (!form) {
            console.error("Formulaire modification examen introuvable");
            return;
        }

        // OUVERTURE DU MODAL
        document.addEventListener("click", (e) => {

            const btn = e.target.closest(".btn-edit-examen");

            if (!btn) return;

            document.getElementById("id_examen_modif").value =
                btn.dataset.id;

            document.getElementById("intitule_modif").value =
                btn.dataset.intitule || "";

            document.getElementById("type_examen_modif").value =
                btn.dataset.type || "";

            document.getElementById("coefficient_modif").value =
                btn.dataset.coefficient || "";

            document.getElementById("date_examen_modif").value =
                btn.dataset.date || "";

            document.getElementById("heure_modif").value =
                btn.dataset.heure || "";

            document.getElementById("lieu_modif").value =
                btn.dataset.lieu || "";

            $("#modifier_examen").modal("show");
        });


        // MODIFICATION
        form.addEventListener("submit", async (e) => {

            e.preventDefault();

            const id_examen =
                document.getElementById("id_examen_modif").value;

            const intitule =
                document.getElementById("intitule_modif").value.trim();

            const type_examen =
                document.getElementById("type_examen_modif").value;

            const coefficient =
                document.getElementById("coefficient_modif").value;

            const date_examen =
                document.getElementById("date_examen_modif").value;

            const heure =
                document.getElementById("heure_modif").value;

            const lieu =
                document.getElementById("lieu_modif").value.trim();


            if (
                !id_examen ||
                !intitule ||
                !type_examen ||
                !coefficient ||
                !date_examen ||
                !heure ||
                !lieu
            ) {

                Swal.fire(
                    "Champs incomplets",
                    "Veuillez remplir tous les champs.",
                    "warning"
                );

                return;
            }


            const data = {

                intitule,

                type_examen,

                coefficient: Number(coefficient),

                date_examen,

                heure: `${date_examen}T${heure}:00`,

                lieu
            };


            console.log("ID EXAMEN :", id_examen);
            console.log("DATA MODIFICATION :", data);


            const token = AdminController.getToken();

            const res = await ExamenModel.updateExamen(
                id_examen,
                token,
                data
            );


            console.log("REPONSE UPDATE :", res);


            if (!res.ok) {

                Swal.fire(
                    "Erreur",
                    res.data?.error ||
                    res.data?.message ||
                    "Impossible de modifier l'examen",
                    "error"
                );

                return;
            }


            Swal.fire(
                "Succès",
                res.data.message,
                "success"
            );


            $("#modifier_examen").modal("hide");

            await this.initDataTable();

        });
    }

    static initDeleteExamen() {

        document.addEventListener("click", async (e) => {

            const btn = e.target.closest(".btn-delete-examen");

            if (!btn) return;

            const id_examen = btn.dataset.id;

            // Confirmation
            const confirmation = await Swal.fire({

                title: "Supprimer l'examen ?",

                text: "Cette action est irréversible.",

                icon: "warning",

                showCancelButton: true,

                confirmButtonText: "Oui, supprimer",

                cancelButtonText: "Annuler"

            });

            if (!confirmation.isConfirmed) {
                return;
            }


            const token = AdminController.getToken();

            try {

                const res = await ExamenModel.deleteExamen(
                    id_examen,
                    token
                );

                console.log("REPONSE SUPPRESSION :", res);


                if (!res.ok) {

                    Swal.fire({

                        icon: "error",

                        title: "Erreur",

                        text:
                            res.data?.error ||
                            res.data?.message ||
                            "Impossible de supprimer l'examen"

                    });

                    return;
                }


                await Swal.fire({

                    icon: "success",

                    title: "Supprimé",

                    text: res.data.message,

                    timer: 1500,

                    showConfirmButton: false

                });


                // Recharger le DataTable
                await this.initDataTable();


            } catch (error) {

                console.error(
                    "ERREUR SUPPRESSION EXAMEN :",
                    error
                );

                Swal.fire({

                    icon: "error",

                    title: "Erreur",

                    text: "Une erreur est survenue lors de la suppression."

                });

            }

        });

    }

}
import DashboardModel from "../models/DashboardModel.js";
import AdminController from "./AdminController.js";

export default class DashboardController {

    static setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.innerText = value;
    }

    static async initDashboard() {

        const token = AdminController.getToken();

        const res = await DashboardModel.getDashboard(token);

        console.log("DASHBOARD :", res);

        if (!res.ok) {
            Swal.fire(
                "Erreur",
                "Impossible de charger le dashboard",
                "error"
            );
            return;
        }

        const data = res.data.data;

        // =========================
        // KPI SIMPLIFIÉS
        // =========================

        this.setText("nb_candidats", data.candidats.total);
        this.setText("nb_concours", data.concours.total);
        this.setText("nb_inscriptions_valides", data.inscriptions.valides);
        this.setText(
            "montant_total",
            (data.paiements.montant_total ?? 0) + " FCFA"
        );

        // ==== CHARTS =====

        // ==========================
        // CHART INSCRIPTIONS
        // ==========================

        const inscriptions = data.inscriptions.parJour || [];

        const labelsInscriptions = inscriptions.map(i =>
            new Date(i.date_inscription).toLocaleDateString()
        );

        const valuesInscriptions = inscriptions.map(i =>
            i._count?._all ?? 0
        );

        new Chart(document.getElementById("chartInscriptions"), {
            type: "line",
            data: {
                labels: labelsInscriptions,
                datasets: [{
                    label: "Inscriptions",
                    data: valuesInscriptions,
                    borderColor: "#4e73df",
                    backgroundColor: "rgba(78,115,223,0.1)",
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });


        // ==========================
        // CHART PAIEMENTS
        // ==========================

        const paiements = data.paiements.recents || [];

        const labelsPaiements = paiements.map(p =>
            p.date_paiement
                ? new Date(p.date_paiement).toLocaleDateString()
                : "N/A"
        );

        const valuesPaiements = paiements.map(p =>
            p.montant || 0
        );

        new Chart(document.getElementById("chartPaiements"), {
            type: "bar",
            data: {
                labels: labelsPaiements,
                datasets: [{
                    label: "Paiements",
                    data: valuesPaiements,
                    backgroundColor: "#1cc88a"
                }]
            },
            options: {
                responsive: true
            }
        });


        // ==========================
        // CHART CONCOURS
        // ==========================

        const concours = data.concours.parType || [];

        new Chart(document.getElementById("chartConcours"), {
            type: "doughnut",
            data: {
                labels: concours.map(c => c.type),
                datasets: [{
                    data: concours.map(c => c._count._all),
                    backgroundColor: [
                        "#4e73df",
                        "#1cc88a",
                        "#36b9cc",
                        "#f6c23e"
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    }

}
// Controllers/CandidatController.js

import CandidatModel from "../models/CandidatModel.js";
import AdminController from "./AdminController.js";

export default class CandidatController {

static async getAll() {

    const token = AdminController.getToken();

    if (!token) {
        console.warn("Aucun token admin");
        return [];
    }

    const res = await CandidatModel.getAllCandidats(token);

    console.log("REPONSE API :", res);

    if (!res.ok) {
        console.log(res.data);
        alert("Erreur chargement candidats");
        return [];
    }

    // CAS 1 : API retourne directement un tableau
    if (Array.isArray(res.data)) {
        return res.data;
    }

    // CAS 2 : API retourne { data: [...] }
    if (Array.isArray(res.data.data)) {
        return res.data.data;
    }

    // CAS 3 : API retourne { candidat: [...] }
    if (Array.isArray(res.data.candidat)) {
        return res.data.candidat;
    }

    return [];
}
    static async initDataTable() {

        const tbody = document.getElementById("candidatTableBody");

        if (!tbody) {
            console.error("tbody introuvable");
            return;
        }

        const data = await this.getAll();

        console.log("DATA API :", data);

        const candidats = data;

        console.log("LISTE CANDIDATS :", candidats);

        tbody.innerHTML = "";

        candidats.forEach((item, index) => {

            const candidat = item;

            tbody.innerHTML += `
<tr>
    <td class="text-center">${index + 1}</td>
    <td class="text-center">${candidat.nom}</td>
    <td class="text-center">${candidat.prenom}</td>
    <td class="text-center">${candidat.nom_jeune_fille}</td>
    <td class="text-center">${candidat.sexe}</td>
    <td class="text-center">${candidat.date_naissance}</td>
    <td class="text-center">${candidat.lieu_naissance}</td>
    <td class="text-center">${candidat.pays_naissance}</td>
    <td class="text-center">${candidat.numero_cnib}</td>
    <td class="text-center">${candidat.date_delivrance}</td>
    <td class="text-center">${candidat.telephone}</td>
    <td class="text-center">${candidat.email}</td>
    <td class="text-center">${candidat.emploi}</td>
    <td class="text-center">${candidat.matricule}</td>
    <td class="text-center">${candidat.ministere}</td>
    <td class="text-center">${candidat.type_candidat}</td>

    <td class="text-center">
        <button class="btn btn-warning btn-sm">
            <i class="fa fa-edit"></i>
        </button>
    </td>

    <td class="text-center">
        <button class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i>
        </button>
    </td> 
    </tr>
        `;
        });

        $('#dataTable').DataTable({
            destroy: true,
            pageLength: 10
        });
    }


    static async getDetail(id) {

        const token = AdminController.getToken();

        const res = await CandidatModel.getDetailCandidat(token, id);

        if (!res.ok) {
            alert("Erreur détail candidat");
            return null;
        }

        return res.data;
    }

    // =========================
    // CREER CANDIDAT
    // =========================
    static async create(data) {

        const token = AdminController.getToken();

        const res = await CandidatModel.createCandidat(token, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur création candidat");
            return false;
        }

        return true;
    }

    // =========================
    // MODIFIER CANDIDAT
    // =========================
    static async update(id, data) {

        const token = AdminController.getToken();

        const res = await CandidatModel.updateCandidat(token, id, data);

        if (!res.ok) {
            alert(res.data.message || "Erreur modification candidat");
            return false;
        }

        return true;
    }

    // =========================
    // SUPPRIMER CANDIDAT
    // =========================
    static async delete(id) {

        const token = AdminController.getToken();

        const res = await CandidatModel.deleteCandidat(token, id);

        if (!res.ok) {
            alert(res.data.message || "Erreur suppression candidat");
            return false;
        }

        return true;
    }

    // =========================
    // RECHERCHE CANDIDAT
    // =========================
    static async search(query) {

        const token = AdminController.getToken();

        const res = await CandidatModel.searchCandidat(token, query);

        if (!res.ok) {
            return [];
        }

        return res.data;
    }
}
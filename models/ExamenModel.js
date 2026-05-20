const API_URL = "http://localhost:4000/api/admin";

export default class ExamenModel {

    static async createExamen(token, data) {
        const res = await fetch(`${API_URL}/examens`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async getExamensByConcours(token, id_concours) {
        const res = await fetch(`${API_URL}/examens/concours/${id_concours}`, {
            headers: {
                "Authorization": "Bearer " + token
            }
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async getDetailExamen(token, id_examen) {
        const res = await fetch(`${API_URL}/examens/${id_examen}`, {
            headers: {
                "Authorization": "Bearer " + token
            }
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async updateExamen(token, id_examen, data) {
        const res = await fetch(`${API_URL}/examens/${id_examen}`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async deleteExamen(token, id_examen) {
        const res = await fetch(`${API_URL}/examens/${id_examen}`, {
            method: "DELETE",
            headers: {
                "Authorization": "Bearer " + token
            }
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async uploadQuestion(token, formData) {
        const res = await fetch(`${API_URL}/upload-exam-question`, {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token
            },
            body: formData
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }
}
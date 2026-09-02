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

    static async getAllExamens(token) {

        const res = await fetch(`${API_URL}/examen/list-exam`, {

            method: "GET",

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

    static async updateExamen(id_examen, token, data) {

        const res = await fetch(
            `${API_URL}/examens/${id_examen}`,
            {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + token
                },
                body: JSON.stringify(data)
            }
        );

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async deleteExamen(id_examen, token) {

        const res = await fetch(
            `${API_URL}/examens/${id_examen}`,
            {
                method: "DELETE",
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            }
        );

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async getExamensByConcours(id_concours, token) {

        const res = await fetch(
            `${API_URL}/examens/concours/${id_concours}`,
            {
                method: "GET",
                headers: {
                    "Authorization": `Bearer ${token}`
                }
            }
        );

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }
}
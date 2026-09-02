const API_URL = "http://localhost:4000/api/admin";

export default class ConcoursModel {

    static async getAllConcours(token) {
        const res = await fetch(`${API_URL}/concours`, {
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

    static async getDetailConcours(token, id) {
        const res = await fetch(`${API_URL}/concours/detail/${id}`, {
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

    static async createConcours(token, data) {
        const res = await fetch(`${API_URL}/create-concours`, {
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

    static async updateConcours(id_concours, token, data) {

        const res = await fetch(`${API_URL}/concours/${id_concours}`, {

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

    static async deleteConcours(id_concours, token) {

        const res = await fetch(`${API_URL}/concours/${id_concours}`, {
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

    static async switchStatutConcours(id_concours, statut_concours, token) {

        const res = await fetch(
            `${API_URL}/concours/${id_concours}/switch-status`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "Bearer " + token
                },
                body: JSON.stringify({
                    statut_concours
                })
            }
        );

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async getCandidatsConcours(token, id_concours) {

        const res = await fetch(
            `${API_URL}/inscriptions/concours-candidat/${id_concours}`,
            {
                headers: {
                    Authorization: "Bearer " + token
                }
            }
        );

        return {
            ok: res.ok,
            data: await res.json()
        };
    }
}
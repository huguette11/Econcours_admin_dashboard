const API_URL = "http://localhost:4000/api/admin";

export default class ConcoursModel {

    static async getAllConcours(token, page = 1) {
        const res = await fetch(`${API_URL}/concours?page=${page}`, {
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

    static async updateConcours(token, id, data) {
        const res = await fetch(`${API_URL}/concours/${id}`, {
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

    static async deleteConcours(token, id) {
        const res = await fetch(`${API_URL}/concours/${id}`, {
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

    static async searchConcours(token, query) {
        const res = await fetch(`${API_URL}/concours/search?q=${query}`, {
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

    static async switchStatus(token, id) {
        const res = await fetch(`${API_URL}/concours/${id}/switch-status`, {
            method: "POST",
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
}
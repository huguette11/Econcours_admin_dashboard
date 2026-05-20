
const API_URL = "http://localhost:4000/api/admin";

export default class CandidatModel {

    static async getAllCandidats(token, page = 1) {
        const res = await fetch(`${API_URL}/candidats?page=${page}`, {
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

    static async getDetailCandidat(token, id) {
        const res = await fetch(`${API_URL}/candidat/detail/${id}`, {
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

    static async searchCandidat(token, query) {
        const res = await fetch(`${API_URL}/candidats/search?q=${query}`, {
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
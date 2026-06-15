
const API_URL = "http://localhost:4000/api/admin";

export default class CandidatModel {

    static async getAllCandidats(token) {
        const res = await fetch(`${API_URL}/candidats/all`, {
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

    static async createCandidat(token, data) {
        const res = await fetch(`${API_URL}/candidats/create`, {
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

    static async DeleteCandidat(token, id_candidat) {

        const res = await fetch(`${API_URL}/candidats/delete/${id_candidat}`, {
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

    static async updateCandidat(token, id_candidat, data) {

        const res = await fetch(
            `${API_URL}/candidats/update-candidat/${id_candidat}`,
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


    static async getDetailCandidat(token, id_candidat) {
        const res = await fetch(`${API_URL}/candidats/detail/${id_candidat}`, {
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

    static async inscrireConcours(token, data) {

        const res = await fetch(
            `${API_URL}/candidats/inscrire-concours`,
            {
                method: "POST",
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

}
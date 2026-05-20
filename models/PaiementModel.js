const API_URL = "http://localhost:4000/api/admin";

export default class PaiementModel {

    static async getPaiements(token, page = 1) {
        const res = await fetch(`${API_URL}/paiements?page=${page}`, {
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

    static async getDetailPaiement(token, id) {
        const res = await fetch(`${API_URL}/paiements/${id}`, {
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

    static async updatePaiementStatus(token, id, statut) {
        const res = await fetch(`${API_URL}/paiements/${id}/status`, {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },
            body: JSON.stringify({ statut })
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }
}
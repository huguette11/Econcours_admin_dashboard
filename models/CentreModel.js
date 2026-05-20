const API_URL = "http://localhost:4000/api/admin";

export default class CentreModel {

    static async createCentre(token, data) {
        const res = await fetch(`${API_URL}/centres`, {
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
}
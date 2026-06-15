const API_URL = "http://localhost:4000/api/admin/centres";

export default class CentreModel {

    static async createCentre(token, data) {
        const res = await fetch(`${API_URL}/create`, {
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

    static async getAllCentres(token) {

        const res = await fetch(`${API_URL}/get-all-centre`, {
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

    static async updateCentre(id_centre, token, data) {

        const res = await fetch(
            `${API_URL}/update-centre/${id_centre}`,
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

    static async deleteCentre(id_centre, token) {

        const res = await fetch(
            `${API_URL}/delete-centre/${id_centre}`,
            {
                method: "DELETE",
                headers: {
                    "Authorization": "Bearer " + token
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
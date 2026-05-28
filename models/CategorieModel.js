const API_URL = "http://localhost:4000/api/admin";

export default class CategorieModel {

    static async getAllCategories(token) {
        const res = await fetch(`${API_URL}/categories`, {
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

    static async createCategorie(token, data) {

        const res = await fetch(`${API_URL}/categories`, {
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


    static async updateCategorie(id_categorie, data, token) {

        const res = await fetch(`${API_URL}/categories/${id_categorie}`, {

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

    static async deleteCategorie(token, id) {
        const res = await fetch(`${API_URL}/categories/${id}`, {
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
}
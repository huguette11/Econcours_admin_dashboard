const API_URL = "http://localhost:4000/api/admin/categories";

export default class CategorieModel {

    static async getAllCategories(token) {
        const res = await fetch(`${API_URL}`, {
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

        const res = await fetch(`${API_URL}`, {
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

        const res = await fetch(`${API_URL}/update-categorie`, {

            method: "PUT",

            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token
            },

            body: JSON.stringify({
                id_categorie: Number(id_categorie),
                libelle: data.libelle,
                description: data.description
            })
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async deleteCategorie(id_categorie, token) {

        const res = await fetch(
            `${API_URL}/delete-categorie/${id_categorie}`,
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
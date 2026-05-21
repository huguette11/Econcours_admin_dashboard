
const API_URL = "http://localhost:4000/api/admin";

export default class AdminModel {

    static async login(data) {
        const res = await fetch(`${API_URL}/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async register(data) {
        const res = await fetch(`${API_URL}/register`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        console.log("BODY FETCH :", JSON.stringify(data));

        const result = await res.json();

        return {
            ok: res.ok,
            data: result
        };
    }

    static async getDashboard(token) {
        const res = await fetch(`${API_URL}/dashboard`, {
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
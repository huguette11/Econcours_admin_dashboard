const API_URL = "http://localhost:4000/api/admin";

export default class DashboardModel {

    static async getDashboard(token) {

        const res = await fetch(`${API_URL}/dashboard`, {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token
            }
        });

        const data = await res.json();

        return {
            ok: res.ok,
            data
        };
    }
}
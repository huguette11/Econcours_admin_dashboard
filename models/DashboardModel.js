const API_URL = "http://localhost:4000/api/admin";

export default class DashboardModel {

    static async dashboard(token) {

        const res = await fetch(
            "http://localhost:4000/api/admin/concours/candidat-by-concours",
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        );

        return {
            ok: res.ok,
            data: await res.json()
        };
    }

    static async getChartCirculaire(token) {

        const res = await fetch(
            "http://localhost:4000/api/admin/concours/circulaire",
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            }
        );

        return {
            ok: res.ok,
            data: await res.json()
        };
    }
}
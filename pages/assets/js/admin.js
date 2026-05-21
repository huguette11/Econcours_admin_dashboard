import AdminController from "../../../Controllers/AdminController.js";

const tbody =
    document.getElementById("adminTableBody");

async function loadAdmins() {

    const data =
        await AdminController.getAllAdmins();

    console.log(data);

}

loadAdmins();
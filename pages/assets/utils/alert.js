export default class Alert {

    static success(message) {
        Swal.fire({
            icon: "success",
            title: "Succès",
            text: message,
            confirmButtonColor: "#28a745"
        });
    }

    static error(message) {
        Swal.fire({
            icon: "error",
            title: "Erreur",
            text: message,
            confirmButtonColor: "#dc3545"
        });
    }

    static warning(message) {
        Swal.fire({
            icon: "warning",
            title: "Attention",
            text: message,
            confirmButtonColor: "#f39c12"
        });
    }

    static info(message) {
        Swal.fire({
            icon: "info",
            title: "Information",
            text: message,
            confirmButtonColor: "#3085d6"
        });
    }

}
document.addEventListener("DOMContentLoaded", () => {

    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll("#accordionSidebar .nav-link")
        .forEach(link => {

            const href = link.getAttribute("href");

            if (href === currentPage) {

                link.classList.add("active");

                const navItem = link.closest(".nav-item");

                if (navItem) {
                    navItem.classList.add("active");
                }
            }
        });

});


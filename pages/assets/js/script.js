document.addEventListener("DOMContentLoaded", function () {
  // Sélectionner tous les liens du menu (hors ceux déjà actifs)
  const navLinks = document.querySelectorAll(".nav-link:not(.active)");

  navLinks.forEach(function (link) {
    // Stocker les couleurs initiales
    const originalBg = window.getComputedStyle(link).backgroundColor;
    const originalColor = window.getComputedStyle(link).color;

    link.addEventListener("mouseover", function () {
      link.style.backgroundColor = "#e1eaf4ff"; // bleu foncé
      link.style.color = "#000000"; // texte blanc
    });

    link.addEventListener("mouseout", function () {
      link.style.backgroundColor = originalBg;
      link.style.color = originalColor;
    });
  });
});

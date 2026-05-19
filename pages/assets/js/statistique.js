function chargerStat(url, elementId) {
  fetch(url)
    .then(response => response.json())
    .then(data => {
      document.getElementById(elementId).textContent = data.total;
    })
    .catch(error => {
      console.error(`Erreur lors du chargement de ${url} :`, error);
      document.getElementById(elementId).textContent = 'Erreur';
    });
}

document.addEventListener("DOMContentLoaded", function () {
  chargerStat("../api/modules/statistiques/statistique_client.php", "nbClients");
  chargerStat("../api/modules/statistiques/statistique_chauffeur.php", "nbChauffeurs");
  chargerStat("../api/modules/statistiques/statistique_car.php", "nbCars");
  chargerStat("../api/modules/statistiques/statistique_voyage.php", "nbVoyages");

});

document.addEventListener('DOMContentLoaded', function () {
  fetch('../api/modules/statistiques/statistique_voyage_mensuelle.php')
    .then(res => res.json())
    .then(data => {
      var ctx = document.getElementById('chart-voyage-annuel').getContext('2d');

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
          datasets: [{
            label: 'Voyages',
            data: data,
            backgroundColor: 'rgba(255,255,255,0.1)',
            borderColor: '#5e72e4',
            pointBackgroundColor: '#5e72e4',
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { labels: { color: '#fff' } }
          },
          scales: {
            x: { ticks: { color: '#fff' } },
            y: {
              beginAtZero: true,
              ticks: { color: '#fff', stepSize: 1 }
            }
          }
        }
      });
    })
    .catch(err => console.error('Erreur chargement données voyages:', err));
});

document.addEventListener('DOMContentLoaded', function () {
  fetch('../api/modules/statistiques/statistique_client_mensuelle.php')
    .then(res => res.json())
    .then(data => {
      var ctx = document.getElementById('chart-client-annuel').getContext('2d');

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
          datasets: [{
            label: 'Réservations',
            data: data,
            backgroundColor: 'rgba(255,255,255,0.1)',
            borderColor: '#5e72e4',
            pointBackgroundColor: '#5e72e4',
            fill: true,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { labels: { color: '#fff' } }
          },
          scales: {
            x: { ticks: { color: '#fff' } },
            y: {
              beginAtZero: true,
              ticks: { color: '#fff', stepSize: 1 }
            }
          }
        }
      });
    })
    .catch(err => console.error('Erreur chargement données clients:', err));
});


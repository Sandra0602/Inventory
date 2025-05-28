const ctx = document.getElementById('ventasChart').getContext('2d');
let ventasChart;

function renderChart(mes) {
  const semanas = ventasPorMes[mes] || [0, 0, 0, 0];

  if (ventasChart) ventasChart.destroy();

  ventasChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
      datasets: [{
        label: 'Ingresos por ventas',
        data: semanas,
        backgroundColor: '#00114d'
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
}

document.getElementById('mesSelect').addEventListener('change', function () {
  renderChart(this.value);
});

// Mostrar el mes actual por defecto
renderChart(document.getElementById('mesSelect').value);

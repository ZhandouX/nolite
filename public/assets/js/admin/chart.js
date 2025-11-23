document.addEventListener('DOMContentLoaded', function () {
    const bulanLabels = window.ChartData.bulanLabels;
    const pendapatanData = window.ChartData.pendapatanData;
    const penggunaData = window.ChartData.penggunaData;

    // Grafik Penjualan
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Penjualan',
                data: pendapatanData,
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true },
                x: {}
            }
        }
    });

    // Grafik Pengguna
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: bulanLabels,
            datasets: [{
                label: 'Pengguna Baru',
                data: penggunaData,
                backgroundColor: 'rgba(14, 165, 233, 0.7)',
                borderColor: '#0ea5e9',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { beginAtZero: true },
                x: {}
            }
        }
    });

    // Animasi untuk grafik saat dimuat
    const charts = document.querySelectorAll('.chart-loading');
    charts.forEach(chart => {
        setTimeout(() => {
            chart.classList.add('chart-loaded');
        }, 300);
    });
});

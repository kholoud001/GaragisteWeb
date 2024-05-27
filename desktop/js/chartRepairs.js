const repairCtx = document.getElementById('repairChart').getContext('2d');
        const repairChart = new Chart(repairCtx, {
            type: 'doughnut',
            data: {
                labels: ['Finies', 'En cours'],
                datasets: [{
                    label: 'Réparations',
                    data: [150, 100],
                    backgroundColor: ['#4caf50', '#f44336'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Réparations'
                    }
                }
            }
        });
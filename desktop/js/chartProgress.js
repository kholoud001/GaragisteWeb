const progressCtx = document.getElementById('progressChart').getContext('2d');
        const progressChart = new Chart(progressCtx, {
            type: 'bar',
            data: {
                labels: ['54859A55', '59101H7', '60875A80', '62711A60',"83303A9","WW7387"],
                datasets: [{
                    label: 'Avancement',
                    data: [20, 80, 50 , 30,60,90],
                    backgroundColor: '#008080'
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Avancement par Voiture'
                    }
                }
            }
        });
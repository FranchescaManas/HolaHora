google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    fetch('../../actions/user/get_activity_data.php')
        .then(response => response.json())
        .then(data => {
            console.log("Fetched Data:", data);

            data.unshift(['Activity', 'Total Hours']);

            var chartData = google.visualization.arrayToDataTable(data);

            var options = {
                pieHole: 0,
                chartArea: {
                    width: '100%',
                    height: '80%'
                },
                legend: {
                    position: 'bottom',  // Positions: 'right', 'left', 'top', 'bottom', 'none'
                    alignment: 'center' // Alignment inside the legend box: 'start', 'center', 'end'
                },
                fontSize: 14
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            
            function resizeChart() {
                var containerWidth = document.getElementById('chart-container').offsetWidth;
                options.width = containerWidth * 0.9; // 90% of container width
                options.height = options.width; // Keep chart square

                chart.draw(chartData, options);
            }

            // Draw chart initially
            resizeChart();

            // Redraw chart when window resizes
            window.addEventListener('resize', resizeChart);
        })
        .catch(error => console.error('Error loading data:', response.json()));
}


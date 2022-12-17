<!DOCTYPE html>
<html>

<head>
</head>

<body>
  <script src="canvas2html.js"></script>
    <div id="chart_div"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
        'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'BEBAS', 'bebas2', 'bebas3'],
            ['Statistic 1', 5000, 4000, 3000],
            ['Statistic 2', 6000, 4000, 3000],
            ['Statistic 3', 1000, 4000, 3000],
            ['Statistic 4', 8100, 4000, 3000],
        ]);

        var options = {
            title: 'INI TEST ELONMUSK CHART',
            hAxis: {
            title: 'Year',
            titleTextStyle: {
                color: '#333'
            }
            },
            vAxis: {
            minValue: 0
            }
        };

        var chart = new google.visualization
                    .BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
        html2canvas(document.getElementById('chart_div'))
            .then(function(canvas) {
            var dataURL = canvas.toDataURL();
            // `dataURL` : `data URI` of chart drawn on `<canvas>` element
            console.log(dataURL);
            })
        }
    </script>
</body>

</html>
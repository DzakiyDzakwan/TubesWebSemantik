<div class="paddsection">
    <div class="container">
            <h1 class="text-center my-5">Total Net Worth</h1>
            <div id="chart_div"></div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
        google.charts.load('current', {
        'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'US$ Miliar'],
            ['2018', <?= $doc->get('wealth:year18') ?>],
            ['2019', <?= $doc->get('wealth:year19') ?>],
            ['2020', <?= $doc->get('wealth:year20') ?>],
            ['2021', <?= $doc->get('wealth:year21') ?>],
            ['2022', <?= $doc->get('wealth:year22') ?>]
        ]);

        var options = {
            title: 'Total Net Worth',
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
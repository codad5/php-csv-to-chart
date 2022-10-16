<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- chart.js cdn  -->
    <title>Hello World!</title>
</head>
<body>
<?php
if(isset($today_rate)){
?>
    <b>Todays Rate : <?=$today_rate?></b>
<?php
}
?>

<h2>Avaliable Rates<h2>
<ul>
    <?php 
    if(isset($rates_array)){
        foreach($rates_array as $key => $value){
            ?>
               <li> <a href="/rates/<?=$value['date']?>"> <?=$value['date']?> </a> </li>
            <?php
        }
    }
?>
</ul>

<h1>OverTime Chart</h1>
<canvas id="myChart" width="400" height="400" style="max-height:600px;max-width:800px;"></canvas>
<!-- <script src="https://www.jsdelivr.com/package/npm/chart.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"
integrity="sha256-+8RZJua0aEWg+QVVKg4LEzEEm/8RFez5Tb4JBNiV5xA=" crossorigin="anonymous"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    
</script>
<script>
    let dates = [],
    rates = []
    window.addEventListener('load', () => {
        console.log('hello');
        fetch('/api/rates')
        .then(res => res.json())
        .then(data => {
            // console.log(data.data)
            data.data.map(values => {
                dates = [...dates, values.date]
                rates = [...rates, values.rate]
            }
            );
            console.log(rates.length, dates.length)
            loadChart(rates, dates)
        })
    })
    function loadChart(rates,dates){
        const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: 'Dollar Rates',
                data: rates,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    }
</script>
</body>
</html>
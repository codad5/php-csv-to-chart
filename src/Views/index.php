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
    <b>Rate on <?=str_replace('%20', ' ', $request?->params('date'))?>  : <?=$today_rate?></b>
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
<b>From : </b>
<select id="select-filter">
    <option value="7days">7 days</option>
    <option value="3week">3 weeks</option>
    <option value="1month">1 Months</option>
    <option value="2months">2 Months</option>
    <option value="3months">3 Months</option>
    <option value="4months">4 Months</option>
    <option value="6months">6 Months</option>
    <option value="1year">1 year</option>
    <!-- <option value="12month">12 Months</option> -->
</select>
<canvas id="myChart" width="400" height="400" style="max-height:600px;max-width:800px;"></canvas>
<!-- <script src="https://www.jsdelivr.com/package/npm/chart.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"
integrity="sha256-+8RZJua0aEWg+QVVKg4LEzEEm/8RFez5Tb4JBNiV5xA=" crossorigin="anonymous"></script>
<script>
    
    const select = document.getElementById('select-filter');
    
</script>
<script>
    let dates = [],
    rates = [],
    chart_check = null;
    window.addEventListener('load', async () => {
        console.log('hello');
        chart_check = loadChart(await getRates());
        
    })

    const getRates = () => {
        return fetch('/api/rates')
        .then(res => res.json())
        .then(data => {
            // console.log(data.data)
            data.data.map(values => {
                dates = [...dates, values.date]
                rates = [...rates, values.rate]
            }
            );
            console.log(rates.length, dates.length)
            // loadChart(rates, dates)
            return data.data
            // loadChart(data.data)
        })
    }
    select.addEventListener('change', async (e) => {
        console.log(e.target.value)
        //destroy chart
        if(chart_check){
            chart_check.destroy();
        }
        chart_check = loadChart(await getRates(), e.target.value)
    })
    function loadChart(datas, filter = '3months'){
        const ctx = document.getElementById('myChart').getContext('2d');
        const aDay = 24 * 60 * 60 * 1000;
        let period = Date.now(),
        dates = [],
        rates = []
        switch(filter){
            case '7days':
                period-=(7 * aDay);
            break;
            case '3week':
                period-=(3 * 7 * aDay);
            break;
            case '1month':
                period-=(30 * aDay);
            break;
            case '2months':
                period-=(60 * aDay);
            break;
            case '3months':
                period-=(90 * aDay);
            break;
            case '4months':
                period-=(30 * 4 * aDay);
            break;
            case '6months':
                period-=(30 * 6 * aDay);
            break;
            case '1year':
                period-=(30 * 12 * aDay);
            break;
            default:
                period-=(90 * aDay);
            break;
        }
        // filter out date that are older than period
        datas = datas.filter((data) => {
            return new Date(data.date) > new Date(period);
        });
        console.log(datas, "hello");
        datas.map(values => {
                dates = [...dates, values.date]
                rates = [...rates, values.rate]
            }
            );
        return new Chart(ctx, {
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
                    // beginAtZero: true
                }
            }
        }
    });
    }
</script>
</body>
</html>

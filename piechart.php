<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="https://codingbirdsonline.com/wp-content/uploads/2019/12/cropped-coding-birds-favicon-2-1-192x192.png" type="image/x-icon">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <title>How to create dynamic pie chart - Coding Birds Online</title>
    <style> .center-block { display: block;margin-left: auto;margin-right: auto; }</style>
</head>
<body>
<div class="container">
    <center>
        <div id="container"></div>
    </center>
    <img class="center-block" src="https://codingbirdsonline.com/wp-content/uploads/2019/12/cropped-coding-birds-favicon-2-1-192x192.png" width="50">
 </div>
<?php
session_start();
		
	require_once 'database.php';
		
$userId=17;
$query = "SELECT sum(amount) as sum, name FROM incomes JOIN incomes_category_assigned_to_users as category ON incomes.income_category_assigned_to_user_id = category.id  
			WHERE incomes.user_id='$userId' 
			GROUP BY name";
	 // get the records on which pie chart is to be drawn
$getData = $db->query($query);
?>
<script>
    // Build the chart
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Programming Language Popularity, 2020'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Udział',
            colorByPoint: true,
            data: [
                <?php
                $data = '';
               
                    while ($row = $getData->fetch(PDO::FETCH_OBJ)){
                        $data.='{ name:"'.$row->name.'",y:'.$row->sum.'},';
                    
                }
                echo $data;
                ?>
            ]
        }]
    });
</script>
</body>
</html>
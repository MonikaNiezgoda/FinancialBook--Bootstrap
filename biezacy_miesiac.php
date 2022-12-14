<?php
	session_start();
		
	require_once 'database.php';
		
	$userId=$_SESSION["logged_id"];
	
	if(!isset($_SESSION['logged_id'])){
	header('Location: index.php');
	exit();
	} else{
		if(isset($_POST['currentMonth']))
			//ustawienie pierwszego i ostatniego dnia bieżącego miesiąca
		$dataod=  date('Y-m-d ', mktime(0,0,0,date('m'),1,date('Y')));
		$datado= date('Y-m-d', mktime(23,59,59,date('m')+1,0,date('Y')));
		{
			$sql = "SELECT sum(amount) as sum, name FROM incomes JOIN incomes_category_assigned_to_users as category ON incomes.income_category_assigned_to_user_id = category.id  
			WHERE incomes.user_id='$userId' AND date_of_income BETWEEN '$dataod' AND '$datado'
			GROUP BY name";
			$userIncomes = $db->query($sql);
			$incomes = $userIncomes -> fetchAll();
			
			$sql = "SELECT sum(amount) as sum, name FROM expenses JOIN expenses_category_assigned_to_users as category ON expenses.expense_category_assigned_to_user_id = category.id  
			WHERE expenses.user_id='$userId' AND date_of_expense BETWEEN '$dataod' AND '$datado'
			GROUP BY name";
			$userExpenses = $db->query($sql);
			$expenses = $userExpenses -> fetchAll();

			$query = "SELECT sum(amount) as sum, name FROM incomes JOIN incomes_category_assigned_to_users as category ON incomes.income_category_assigned_to_user_id = category.id  
						WHERE incomes.user_id='$userId'AND date_of_income BETWEEN '$dataod' AND '$datado'
						GROUP BY name"; 	
				 // get the records on which pie chart is to be drawn
			$getDataIncomes = $db->query($query);
			
			$query = "SELECT sum(amount) as sum, name FROM expenses JOIN expenses_category_assigned_to_users as category ON expenses.expense_category_assigned_to_user_id = category.id  
			WHERE expenses.user_id='$userId' AND date_of_expense BETWEEN '$dataod' AND '$datado'
			GROUP BY name";	
				 // get the records on which pie chart is to be drawn
			$getDataExpenses = $db->query($query);

		}
				
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Przeglądanie bilansu</title>
	<meta name="description" content="Przeglądaj bilans">
	<meta name="keywords" content="przeglądanie, bilansu, aplikacja, finansowa, menu">
	<meta name="author" content="Monika Niezgoda">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"> 
	
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
		<header>
				<h1 class="display-5 h-5 text-center"> Twój budżet</h1>
				
				<nav class="navbar navbar-expand-lg navbar-light bg-light" >
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarToggler">
				<ul class="navbar-nav mr-auto ml-3  mt-lg-0">
				  <li class="nav-item ">
					<a class="nav-link" href="menu_glowne.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"/>
						<path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
					</svg> Strona Główna <span class="sr-only">(current)</span>
					</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="dodaj_przychod.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
					  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
					  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
					  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
					  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
					</svg> Dodaj przychód</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="dodaj_wydatek.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket3-fill" viewBox="0 0 16 16">
					  <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H.5a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 .5 6h1.717L5.07 1.243a.5.5 0 0 1 .686-.172zM2.468 15.426.943 9h14.114l-1.525 6.426a.75.75 0 0 1-.729.574H3.197a.75.75 0 0 1-.73-.574z"/>
					</svg> Dodaj wydatek</a>
				  </li>
				  <li class="nav-item active">
					<a class="nav-link " href="przegladaj_bilans.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-fill" viewBox="0 0 16 16">
						  <path d="M1 11a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3zm5-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2z"/>
					</svg> Przeglądaj bilans</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
					  <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
					</svg> Ustawienia</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link " href="wyloguj.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
					  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
					  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
					</svg> Wyloguj się</a>
									  </li>
				</ul>
					  <span class="navbar-text">
						Witaj <?php echo $_SESSION['imie']?>!
					  </span>

			  </div>
			</nav>
			
		</header>
				<main>
					<div class="container">
					
						<div class="row justify-content-center mb-2 mt-2">
							<div class= "col-md-4">
								<h3> Przeglądanie bilansu</h3>
							</div>
							<div class="col-md-4">	
								<div class="dropdown">
									  <button class=" dropdown-toggle btn btn-warning" type="button" data-toggle="dropdown" aria-expanded="false">
										Wybierz zakres dat
									  </button>
									   
										<div class="dropdown-menu">
											<form method="post" action="biezacy_miesiac.php">
											<input class="dropdown-item btn btn-warning" type="submit"   name="currentMonth" value="Bieżący miesiąc">
											</form>
											<form method="post" action="poprzedni_miesiac.php">
											<input class="dropdown-item btn btn-warning" type="submit"   name="previousMonth" value="Poprzedni miesiąc">
										</form>
										<form method="post" action="biezacy_rok.php">
											<input class="dropdown-item btn btn-warning" type="submit"   name="currentYear" value="Bieżący rok">
										</form>
										 </div>
								</div>
							</div>
						</div>
							<div class="row">
									<div class="col-md-6 my-2">
										<table class="table table-bordered table-hover">
											<thead>
												<tr>
												<th colspan="2" class="text-center"> Przychody z bieżącego miesiąca</th>
												</tr>
												<tr>
													<th scope="col">Kategoria</th>
													<th scope="col">Suma</th>
												</tr>
												<tbody>
												<?php
													$sumIncomes=0;
													foreach($incomes as $incomes){
													$sumIncomes+=$incomes['sum'];
													echo "<tr><td>{$incomes['name']} </td>  <td>{$incomes['sum']}</td></tr>";
													}
													$sumIncomes = number_format($sumIncomes,2,'.','');
													echo "<tr><td>RAZEM</td>  <td> $sumIncomes</td></tr>";
												?>
												</tbody>
											</thead>
										</table>	
									</div>
								
								
								<div class="col-md-6 my-2">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
											<th colspan="2" class="text-center"> Wydatki z bieżącego miesiąca</th>
											</tr>
											<tr>
												<th scope="col">Kategoria</th>
												<th scope="col">Suma</th>
											</tr>
											<tbody>
											<?php $sumExpenses=0;
													foreach($expenses as $expenses){
													$sumExpenses+=$expenses['sum'];
													echo "<tr><td>{$expenses['name']} </td>  <td>{$expenses['sum']}</td></tr>";
													}
													$sumExpenses = number_format($sumExpenses,2,'.','');
													echo "<tr><td>RAZEM</td>  <td> $sumExpenses</td></tr>";
												?>

											</tbody>
										</thead>
									</table>
								</div>
							</div>

								<div class="d-flex justify-content-center row" >
											<a  role="button" class="btn btn-success col-6 text-center mt-2" data-toggle="collapse" href="#piecharts" <?php if($sumExpenses>$sumIncomes) { echo 'href="#collapseAlert"';} else {echo ' href="#collapseAlert2"';} ?>  aria-expanded="false" aria-controls="collapse">Podsumuj</a>		
										</div>
										<div class=" collapse mt-2" id="piecharts">
											<div class="row">
												<div class="col-md-6" id="chartIncomes"></div>
												<div class="col-md-6" id="chartExpenses"></div>
											</div>
											<?php if($sumIncomes>$sumExpenses){
											echo "<div class='alert alert-success mt-2' role='alert'>
												Gratulacje. Świetnie zarządzasz finansami!
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
											</div>";
											}else {
												echo "<div class='alert alert-danger mt-2' role='alert'>
												Gratulacje. Świetnie zarządzasz finansami!
												<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
												<span aria-hidden='true'>&times;</span>
												</button>
											</div>";

											}
											?>
										</div>
															
					</div>
					
				</main>

	<script>
    // Build the chart
    Highcharts.chart('chartIncomes', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Wykres przychodów za bieżący miesiąc'
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
               
                    while ($row = $getDataIncomes->fetch(PDO::FETCH_OBJ)){
                        $data.='{ name:"'.$row->name.'",y:'.$row->sum.'},';
                    
                }
                echo $data;
                ?>
            ]
        }]
    });
</script>
<script>
    // Build the chart
    Highcharts.chart('chartExpenses', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Wykres wydatków za bieżący miesiąc'
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
               
                    while ($row = $getDataExpenses->fetch(PDO::FETCH_OBJ)){
                        $data.='{ name:"'.$row->name.'",y:'.$row->sum.'},';
                    
                }
                echo $data;
                ?>
            ]
        }]
    });
</script>

			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			
			<script src="js/bootstrap.min.js"></script>
			
</body>
</html>

<?php
	
	session_start();

?>

<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Strona główna</title>
	<meta name="description" content="Strona główna aplikacji finansowej">
	<meta name="keywords" content="strona, główna, aplikacja, finansowa, menu">
	<meta name="author" content="Monika Niezgoda">
	<meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet"> 
	
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
	
</head>

<body>
		<header>
				<h1 class="display-5 h-5 text-center my-2"> Twój budżet</h1>
				
				
					<blockquote class="blockquote text-center" style="color: #D6983A; font-style:italic">  
						<p class="mt-1 mb-0  mx-2" >Zrobić budżet to wskazać swoim pieniądzom, dokąd mają iść, zamiast się zastanawiać, gdzie się rozeszły
						</p>
						  <footer class="blockquote-footer">  John C. Maxwell.</footer>
					</blockquote>
		</header>
				<main>
					<div class="container">
					 <div class="row mt-2">
							<div class="col-md-6 text-center mt-2">
								<div class="row justify-content-center">
									<div class="col-10 mb-3 align-items-center">
										<a class="btn btn-warning btn-block" href="rejestracja.php" role="button"> Rejestracja <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
										  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
										  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
										</svg></a>
									
									</div> 
								</div>
								<div class="row justify-content-center">
									<div class="col-10 mb-2">
										<a class="btn btn-success btn-block" href="logowanie.php" role="button"> Logowanie <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
									  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
									</svg></a>
										<?php
											if (isset($_SESSION['udanarejestracja']))
											{
												echo '<br/><div class="info">'.$_SESSION['udanarejestracja'].'</div><br/>';
												unset($_SESSION['udanarejestracja']);
											}
										?>
									</div>
								</div>
							</div>
							<div class="col-md-6  text-center">
								<img src="img/portfel.jpg" class="img-fluid rounded" alt="portfel">
							</div>
					 </div>
					</div>
				</main>
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			
			<script src="js/bootstrap.min.js"></script>
</body>
</html>
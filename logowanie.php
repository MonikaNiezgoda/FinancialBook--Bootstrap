<?php
session_start();
if (isset($_SESSION['logged_id'])) {
	header('Location: menu_glowne.php');
	exit();
}
?>


<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Logowanie</title>
	<meta name="description" content="Logowanie">
	<meta name="keywords" content="logowanie, aplikacja, finansowa, menu">
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
				
				
					<blockquote class="blockquote text-center" style="color: #D6983A;font-style:italic">  
						<p class="mt-1 mb-0 " >Zrobić budżet to wskazać swoim pieniądzom, dokąd mają iść, zamiast się zastanawiać, gdzie się rozeszły
						</p>
						  <footer class="blockquote-footer">  John C. Maxwell.</footer>
					</blockquote>
					</blockquote>
		</header>
				<main>
					<div class="container ">
						<div class="row justify-content-center mb-2 mt-2">
						<h3> Logowanie </h3>
						</div>
						<form method="post" action="menu_glowne.php">
						<div class="row justify-content-center">
							<div class="col-8  col-md-6">
								<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon">@</span>
										  </div>
										  <input type="email" class="form-control" placeholder="Email" aria-label="UserEmail" aria-describedby="basic-addon" name="email">
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-8  col-md-6">
								<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
												  <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/>
												</svg></span>
										  </div>
										  <input type="password" class="form-control" placeholder="Hasło" aria-label="UserPassword" aria-describedby="basic-addon" name="haslo">
								</div>
							 </div>
						</div>
					
						<div class="row justify-content-center">
			
								<div class="col-4  col-md-3">
								 <input type="submit" value="Zaloguj się" class="btn btn-success btn-md btn-block">
								</div>
		
								<div class="col-4  col-md-3">
								  <a  class="btn btn-secondary btn-md btn-block" href="index.php" role="button">Anuluj</a>
								</div>
								
						</div>
						<div class=" row justify-content-center error">
						<?php
									if (isset($_SESSION['bad_attempt'])) {
										echo '<p>Niepoprawny login lub hasło!</p>';
										unset($_SESSION['bad_attempt']);
									}
									?>
						</div>
					</form>
						
				</div>
				
				</main>
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			
			<script src="js/bootstrap.min.js"></script>
</body>
</html>
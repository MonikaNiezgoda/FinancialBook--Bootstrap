<?php

	session_start();
	
	require_once "database.php";
	
	if(isset($_POST['email']))
	{
		//Udana walidacja - flaga ustawiona true
		$wszystko_OK=true;
		
		$imie=$_POST['imie'];
		
		//Sprawdzenie poprawności adresu email
		
		$email = filter_input(INPUT_POST, 'email',FILTER_VALIDATE_EMAIL);
		
		if(empty($email)){
			
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Niewłaściwy adres email!";
		}
			else{
			
			$rezultat = $db->prepare("SELECT id FROM users WHERE email= :email");
			$rezultat->bindValue(':email',$email, PDO::PARAM_STR);
			$rezultat->execute();
				
			$ile_takich_maili = $rezultat->rowCount();
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
					$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}
			}
			
			
			//Sprawdź poprawność hasła
		$haslo = $_POST['haslo'];
		
		if ((strlen($haslo)<8) || (strlen($haslo)>20))
		{
			$wszystko_OK=false;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);
		

				if ($wszystko_OK==true)
				{
					
					$query = $db->prepare("INSERT INTO users VALUES (NULL, '$imie', '$haslo_hash', :email)");
					$query->bindValue(':email', $email, PDO::PARAM_STR);
					$query->execute();
					
					$userQuery = $db->prepare('SELECT id FROM users WHERE email = :email');
					$userQuery->bindValue(':email', $email, PDO::PARAM_STR);
					$userQuery->execute();
					
					$user = $userQuery->fetch();
	
					$userId=$user['id'];
					
					//dodanie kategorii przychodow defaultowych do tabeli z przypisanymi do usera
					$incomesQuery  = $db->query('SELECT * FROM incomes_category_default');
					$incomesCategory = $incomesQuery->fetchAll();
					
					foreach($incomesCategory as $incomesCategory) {
					$categoryName=$incomesCategory['name'];
					$userIncomes= $db->exec("INSERT INTO incomes_category_assigned_to_users VALUES (NULL, '$userId', '$categoryName')");
					}
					
					//dodanie kategorii wydatków defaultowych do tabeli z przypisanymi do usera
					$expensesQuery  = $db->query('SELECT * FROM expenses_category_default');
					$expensesCategory = $expensesQuery->fetchAll();
					
					foreach($expensesCategory as $expensesCategory) {
					$categoryExpenseName=$expensesCategory['name'];
					$userExpenses= $db->exec("INSERT INTO expenses_category_assigned_to_users VALUES (NULL, '$userId', '$categoryExpenseName')");
					}
					
						$_SESSION['udanarejestracja']="Rejestracja się powiodła, teraz możesz się zalogować.";
						header('Location: index.php');
				}
						
	}
?>


<!DOCTYPE html>
<html lang="pl">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Rejestracja</title>
	<meta name="description" content="Rejestracja">
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
						<h3> Rejestracja </h3>
						</div>
					<form  method="post">
						<div class="row justify-content-center">
							<div class=" col-8  col-md-6">
								<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
											  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
											</svg></span>
										  </div>
										  <input type="text" class="form-control" placeholder="Imię" aria-label="Username" aria-describedby="basic-addon" name="imie">
								</div>
							</div>
						</div>
						<div class="row justify-content-center">
							<div class="col-8  col-md-6">
								<div class="input-group mb-3">
										  <div class="input-group-prepend">
											<span class="input-group-text" id="basic-addon">@</span>
										  </div>
										  <input type="email" class="form-control" placeholder="Email" aria-label="UserEmail" aria-describedby="basic-addon" name="email"/>	 <br/>
										  <?php
											if (isset($_SESSION['e_email']))
											{
												echo '<br/><div class="error">'.$_SESSION['e_email'].'</div><br/>';
												unset($_SESSION['e_email']);
											}
										?>
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
										  <?php
											if (isset($_SESSION['e_haslo']))
											{
												echo '<br/><div class="error">'.$_SESSION['e_haslo'].'</div>';
												unset($_SESSION['e_haslo']);
											}
										?>		
								</div>
							 </div>
						</div>
					
					
						<div class="row justify-content-center">
			
								<div class="col-4  col-md-3">
								 <input type="submit" value="Zarejestruj się" class="btn btn-success btn-md btn-block"/>
								</div>
		
								<div class="col-4  col-md-3">
								  <a  class="btn btn-secondary btn-md btn-block" href="index.html" role="button">Anuluj</a>
								</div>
						</div>
					</form>
				
					</div>
				</main>
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			
			<script src="js/bootstrap.min.js"></script>
</body>
</html>
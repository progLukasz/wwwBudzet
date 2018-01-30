<?php
	session_start();
	
	if(isset($_SESSION['logged']) && ($_SESSION['logged']==true))
	{
		header('Location: kontroluj-swoje-wydatki');
		exit();
	}
	

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Budżet Domowy</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
	<meta name="description" content="Strona pomagająca w prowadzeniu budżetu domowego i ograniczenia niepotrzebnych wydatków.">
	<meta name="keywords" content="budżet, wydatki, pieniądze, wydawanie, zarządzanie pieniędzmi">
	<meta name="author" content="Lukasz Wojciech">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
	
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="css/fontello.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Audiowide|Caveat|Courgette|Kalam|Vollkorn+SC" rel="stylesheet">
	
</head>

<body>
	
	<div id="topbar">	
		<br/>
	</div>
	
	<header id="header">
		<h1>Budżet domowy</h1><h3>Utrzymuj swoje wydatki w ryzach!</h3>
	</header>																																			
	<main id="loggingScreen">			
			<?php
				if(isset($_SESSION['deleted'])) echo $_SESSION['deleted'];
			?>
		<form id="form1" action="LogIn.php" method="post">
			<span class="words">Aby korzystać, zaloguj się</span> <br /><br />
			 <input type="text" name="login" placeholder="Login" onfocus="this.placeholder=' '" onblur="this.placeholder='Login'"/> <br /> <br />
			 <input type="password" name="pass" placeholder="Hasło" onfocus="this.placeholder=' '" onblur="this.placeholder='Hasło'"/> <br /> <br />
			<?php
				if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
			?> <br />
			<input type="submit" value="Zaloguj się"> <br /><br />
		</form>
		<form id="form2" action="SignIn.php" method="post">
				<span class="words">lub załóż konto za darmo!</span> <br /> <br />
			<input type="text" name="loginNew" placeholder="Login" onfocus="this.placeholder=' '" onblur="this.placeholder='Login'"/> <br /> <br />
			<?php
				if(isset($_SESSION['e_nick']))
				{
				echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
				unset($_SESSION['e_nick']);
				}
			?>
			<input type="text" name="emailNew" placeholder="Adres email" onfocus="this.placeholder=' '" onblur="this.placeholder='Adres email'"/> <br /> <br />
			<?php
				if(isset($_SESSION['e_email']))
				{
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
				}
			?>
			<input type="password" name="passNew1" placeholder="Hasło" onfocus="this.placeholder=' '" onblur="this.placeholder='Hasło'"/> <br /> <br />
			<input type="password" name="passNew2" placeholder="Powtórz hasło" onfocus="this.placeholder=' '" onblur="this.placeholder='Powtórz hasło'"/> <br /> <br />
			<?php
				if(isset($_SESSION['e_password']))
				{
				echo '<div class="error">'.$_SESSION['e_password'].'</div>';
				unset($_SESSION['e_password']);
				}
			?>
			<input type="checkbox" name="terms">Akceptuję <a href="Terms.php" target="_new" class="links">Regulamin</a><br /> <br />
			<?php
				if(isset($_SESSION['e_terms']))
				{
				echo '<div class="error">'.$_SESSION['e_terms'].'</div>';
				unset($_SESSION['e_terms']);
				}
			?>
			<div class="g-recaptcha" data-sitekey="6LdsfzoUAAAAAE1_Y4u0_prfFFYmxko2KqO2Kr12"></div> <br />
			<?php
				if(isset($_SESSION['e_bot']))
				{
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
				}
			?>
			<input type="submit" value="Załóż konto"> <br /><br />
			<?php
				if(isset($_SESSION['e_server']))
				{
				echo '<div class="error">'.$_SESSION['e_server'].'</div>';
				unset($_SESSION['e_server']);
				}
			?>
		</form>		
		<span style="both: clear;"></span>
	</main>
	
	
	<footer style="clear:both;">
		<div id="info">
		
		</div>
	
	</footer>
		
</body>

</html>
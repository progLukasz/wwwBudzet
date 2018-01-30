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
		<span class="links" onclick="window.close();" style="cursor:pointer;">Zamknij okno</span> 
	</div>
	
	<header id="header">
		<h1>Budżet domowy</h1><h3>Utrzymuj swoje wydatki w ryzach!</h3>
	</header>																																			
	<main>	
		<span id="terms">Strona w budowie.</span><br/>
	</main>
	
	
	<footer style="clear:both;">
		<div id="info">
		
		</div>
	
	</footer>
		
</body>

</html>
<?php

	session_start();
	
	if(!isset($_SESSION['logged']))		
	{
		header('Location: budzet-domowy');
		exit();
	}	

	$backToMain = false;
	if(isset($_SESSION['backToMain']))
	{		
		$backToMain =  $_SESSION['backToMain'];
		unset ($_SESSION['backToMain']);
	};	
			
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title>Budżet Domowy</title>
	<meta name="description" content="Strona pomagająca w prowadzeniu budżetu domowego i ograniczenia niepotrzebnych wydatków.">
	<meta name="keywords" content="budżet, wydatki, pieniądze, wydawanie, zarządzanie pieniędzmi">
	<meta name="author" content="Lukasz Wojciech">
	
	<meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
	
	<link rel="stylesheet" href="style.css?version=4 type="text/css" />
	<link href="css/fontello.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Audiowide|Caveat|Courgette|Kalam|Vollkorn+SC" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	
	<script type="text/javascript">
	
		var $backToMain  = "<?php echo $backToMain ?>";
		
			function showInfo()
			{
				if ($backToMain == false)
				{ 
					$("#anyOtherRunInfo").hide();
					$("#firstRunInfo").hide().fadeIn(2000);
				}
				else {
					$("#firstRunInfo").hide();
					$("#anyOtherRunInfo").hide().fadeIn(2000);
				}
			}

	</script>
</head>

<body onload="showInfo()">
	
	<div id="topbar">
			<?php
				echo '<span style="color: #34a02c;">Witaj '.$_SESSION['user'].'!</span>' ;
			?>
		<a href="ustawienia-konta" style="color: #34a02c;"><i class="icon-cog"></i></a>
		<a href="LogOut.php" class="links">Wyloguj się</a>
	</div>
	<header id="header">
		<h1>Budżet domowy</h1><h3>Utrzymuj swoje wydatki w ryzach!</h3>
	</header>
	<div id="mainContainer">	
		<nav id="menu">

			<a href="dodaj-wydatki" class="mainMenu">Dodaj wpis</a>
			<a href="wyswietl-wydatki" class="mainMenu">Wyświetl wydatki</a>
			<a href="wyswietl-podsumowanie" class="mainMenu">Wyświetl podsumowanie</a>
			<a href="edytuj-kategorie" class="mainMenu">Edytuj kategorie</a>
			<a href="edytuj-metody-platnosci" class="mainMenu">Edytuj metody płatności</a>

					
		</nav>

		<main id="mainPage">
			
			<?php
						if(isset($_SESSION['e_main']))
						{
						echo '<div class="error">'.$_SESSION['e_main'].'</div>';
						unset($_SESSION['e_main']);
						}
						else	echo '<span id="firstRunInfo" class="greetingsInfo">Witam!<br/> Aby rozpocząć, wybierz jedną z opcji z lewego menu.<br />Jeśli jesteś nowym użykownikiem, sugeruję najperw dodać właśne kategrie wydatków i metody płatności.</span>
			<span id="anyOtherRunInfo" class="greetingsInfo"><br/> Zadanie zakończone powodzeniem.<br />Wybierz z menu co chciałbyś teraz zrobić</span>';
					?>
		</main>
		<span style="clear:both;"></span>
	</div>
	
	
	<footer>
		<div id="info">
		
		</div>
	
	</footer>
	
	
	
</body>

</html>
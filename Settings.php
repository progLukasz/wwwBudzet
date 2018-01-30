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
		
		$(document).ready(function() {
			
			
			$("#buttLogin").click(function() {
				var newLogin = $("#loginNew").val();
				$("#messageLogin").load("SettingsPHP.php", {
					changeLogin: newLogin
				});	
			});
			
			$("#buttEmail").click(function() {
				var newEmail = $("#emailNew").val();
				$("#messageEmail").load("SettingsPHP.php", {
					changeEmail: newEmail
				});
			});
		
			$("#buttPass").click(function() {
				var oldPass = $("#passOld").val();
				var newPass1 = $("#passNew1").val();
				var newPass2 = $("#passNew2").val();
				$("#messagePass").load("SettingsPHP.php", {
					changePassOld: oldPass,
					changePassNew1: newPass1,
					changePassNew2: newPass2
				});
			});
			
			$("#buttDel").click(function() {
				window.location.href = "DeleteAccount.php";
				//window.location('DeleteAccount.php');
			});
			
		});
		
	</script>
	
	<style>
		
	</style>
</head>

<body>
	
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
				<div class="settings" style="text-align: center; padding-top: 0px;"><h3>Ustawienia<h3></div> <br />
				<div id="setLogin" class="settings">
					<span style="margin-left: 350px;">Zmień login</span><br />
					Podaj nowy login:
					<input type="text" id="loginNew" placeholder="Login" onfocus="this.placeholder=' '" onblur="this.placeholder='Login'"/>
					<button id="buttLogin" class="buttons" style="margin-left: 100px;">Potwierdź zmianę loginu</button>
					<div id="messageLogin" class="message"></div>
				</div><br /> <br />
				<div id="setEmail" class="settings">
					<span style="margin-left: 350px;">Zmień adres email</span><br />
					Podaj nowy adres email:
					<input type="text" id="emailNew" placeholder="Adres email" onfocus="this.placeholder=' '" onblur="this.placeholder='Adres email'"/>
					<button id="buttEmail" class="buttons" style="margin-left: 40px;">Potwierdź zmianę adresu email</button>
					<div id="messageEmail" class="message"></div>
				</div><br /> <br />
				<div id="setPass" class="settings">
					<span style="margin-left: 350px;">Zmień haslo</span><br />
					Podaj stare hasło:
					<input type="password" id="passOld" placeholder="Stare Hasło" onfocus="this.placeholder=' '" onblur="this.placeholder='Stare Hasło'"/> <br /> <br />
					Podaj nowe hasło:
					<input type="password" id="passNew1" placeholder="Nowe Hasło" onfocus="this.placeholder=' '" onblur="this.placeholder='Nowe Hasło'"/> <br /> <br />
					Powtórz nowe hasło:
					<input type="password" id="passNew2" placeholder="Powtórz hasło" onfocus="this.placeholder=' '" onblur="this.placeholder='Powtórz hasło'"/>
					<button id="buttPass" class="buttons" style="margin-left: 80px;">Potwierdź zmianę hasła</button>
					<div id="messagePass" class="message"></div>
				</div><br /> <br />	
				<div id="delAccount" class="settings">
					<button id="buttDel" class="buttons" style="margin-left: 480px; ">Usuń konto</button>
				</div>
				
		</main>
		<span style="clear:both;"></span>
	</div>
	
	
	<footer>
		<div id="info">
		
		</div>
	
	</footer>
	
	
	
</body>

</html>
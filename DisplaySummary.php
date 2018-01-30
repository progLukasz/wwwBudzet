<?php

	session_start();
		
	
	if(!isset($_SESSION['logged']))		
	{
		header('Location: budzet-domowy');
		exit();
	}		
	
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
	
	<link rel="stylesheet" href="style.css?version=11 type="text/css" />
	<link href="css/fontello.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Audiowide|Caveat|Courgette|Kalam|Vollkorn+SC" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="Chart.js"></script>
	<script src="script.js"></script>
	
	<script type="text/javascript">
	
		var d = new Date();
		var month = d.getMonth()+1;
		var day = d.getDate();
		var year = d.getFullYear();
		

		if(month == 1) {
			var prevMonth = 12;
			var prevYear = year - 1;
		} else {
			var prevMonth = month - 1;
			var prevYear = year;
		};

		$(function(){
			$('#thisMonthSum').click(function(){
				$('#content').css('display', 'block');
				$('#selectPeriod').css('display', 'none');
				$("#content").load("RequestSummary.php", {
					startDate: year + '-' + month + '-00',
					endDate: year + '-' + month + '-' + day
				});	
			});
		});
		
		$(function(){
			$('#lastMonthSum').click(function(){
				$('#content').css('display', 'block');
				$('#selectPeriod').css('display', 'none');
				$("#content").load("RequestSummary.php", {
					startDate: prevYear + '-' + prevMonth + '-00',
					endDate: prevYear + '-' + prevMonth + '-30'
				});
			});
		});
		
		$(function(){
			$('#selectSum').click(function(){	
				$('#content').css('display', 'none');
				$('#selectPeriod').fadeIn(500);
				$('#selectPeriod').css('display', 'block');
				});
			});
		
		$(function(){
			$('#button').click(function(){	
				$('#selectPeriod').css('display', 'none');
				$('#content').css('display', 'block');
				$("#content").load("RequestSummary.php", {
					startDate: $('#startDateText').val(),
					endDate: $('#endDateText').val()
				});
			});
		});
		
		$(function(){
			$('#fromBegining').click(function(){
				$('#content').css('display', 'block');
				$('#selectPeriod').css('display', 'none');
				$("#content").load("RequestSummary.php", {
					startDate: '0000-00-00',
					endDate: year + '-' + month + '-' + day
				});
			});
		});
		
			
	</script>
</head>

<body onload="colapseMenu('.sub1');">
	
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
			<div id="expandSumm" class="mainMenuActive">Wyświetl podsumowanie</div>
				<div id="thisMonthSum" class="subMenu sub1">Z tego miesiąca</div>
				<div id="lastMonthSum" class="subMenu sub1">Z poprzedniego miesiąca</div>
				<div id="selectSum" class="subMenu sub1">Z wybranego okresu</div>
				<div id="fromBegining" class="subMenu sub1">Całościowe</div>
			<a href="edytuj-kategorie" class="mainMenu">Edytuj kategorie</a>
			<a href="edytuj-metody-platnosci" class="mainMenu">Edytuj metody płatności</a>
					
		</nav>

		<main id="mainPage">
			<div id="content" style="display: none;">
			</div>
			<div id="selectPeriod" class="formEdit" style="display: none;">
				Wyświetl wydatki z okresu <br/> 
				od:
				<input type="text" id="startDateText" placeholder="RRRR/MM/DD" onfocus="this.placeholder="" onblur="this.placeholder="RRRR/MM/DD"/>
				do:
				<input type="text" id="endDateText" placeholder="RRRR/MM/DD" onfocus="this.placeholder="" onblur="this.placeholder="RRRR/MM/DD"/> <br />
				<input type="submit" value="Zatwierdź" id="button"> <br />		
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
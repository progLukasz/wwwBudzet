<?php

	session_start();
	
	if(!isset($_SESSION['logged']))		
	{
		header('Location: budzet-domowy');
		exit();
	}		
		
	require_once "Connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);	
	try
			{
				$connection = new mysqli($host, $db_user, $db_password, $db_name);

				if($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$resultCath = $connection->query("SELECT CathegoryID, Name FROM cathegories WHERE userID = '".$_SESSION['userId']."'");
					$dataCath  = array();
					while ($row = mysqli_fetch_assoc($resultCath))
					{
						$dataCath[] = $row;
					}
					$resultPayMeth = $connection->query("SELECT PayMetID, Name FROM paymentmethod WHERE userID = '".$_SESSION['userId']."'");
					$dataPayMeth  = array();
					while ($row = mysqli_fetch_assoc($resultPayMeth))
					{
						$dataPayMeth[] = $row;
					}
					$connection->close();
				}
				
			}
			
			catch(Exception $e)
			{
				$_SESSION['e_server'] = '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o zalogowanie się w innym terminie.</span>';
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
	<script src="script.js"></script>
	
	<script type="text/javascript">


	$(document).ready(function() {
	
			$('#allExps').click(function(){
				$('#content').css('display', 'block');
				$('#selectCath').css('display', 'none');
				$('#selectPayMeth').css('display', 'none');
				$('#selectComment').css('display', 'none');
				$('#selectDate').css('display', 'none');
				$("#content").load("RequestExpenses.php", {
					sortedBy: 'all',
					keyword: ''
				});	
			});
		
			$('#byCathegory').click(function(){
			changeContent_2('#selectCath', '#selectPayMeth', '#selectComment', '#selectDate', '#content');
			});

			$('#byPayMeth').click(function(){
			changeContent_2('#selectPayMeth', '#selectCath', '#selectComment', '#selectDate', '#content');
			});
		
			$('#byComment').click(function(){
			changeContent_2('#selectComment', '#selectCath', '#selectPayMeth', '#selectDate', '#content');
			});
			
			$('#byDate').click(function(){
			changeContent_2('#selectDate', '#selectCath', '#selectPayMeth', '#selectComment', '#content');
			});
	
			$('#buttonCath').click(function(){
				$('#selectCath').css('display', 'none');
				$('#content').css('display', 'block');
				var displayCath = $("#selCath").val();
				$("#content").load("RequestExpenses.php", {
					sortedBy: 'cathegory',
					display: displayCath
				});	
			});
	
			$('#buttonPayMeth').click(function(){
				$('#selectPayMeth').css('display', 'none');
				$('#content').css('display', 'block');
				var displayPayMeth = $("#selPayMeth").val();
				$("#content").load("RequestExpenses.php", {
					sortedBy: 'payMeth',
					display: displayPayMeth
				});	
			});
	
			$('#buttonComment').click(function(){
				$('#selectComment').css('display', 'none');
				$('#content').css('display', 'block');
				var displayComment = $("#selComment").val();
				$("#content").load("RequestExpenses.php", {
					sortedBy: 'comment',
					display: displayComment
				});	
			});
	
			$('#buttonDate').click(function(){
				$('#selectDate').css('display', 'none');
				$('#content').css('display', 'block');
				$("#content").load("RequestExpenses.php", {
					sortedBy: 'date',
					startDate: $('#startDateText').val(),
					endDate: $('#endDateText').val()
				});	
			});	
			
	});
		
	</script>
</head>

<body onload="colapseMenu('.sub4');">
	
	<div id="topbar">
			<?php
				echo '<span style="color: #34a02c;">Witaj '.$_SESSION['user'].'!</span>' ;
			?>
			<a href="ustawienia-konta Settings" style="color: #34a02c;"><i class="icon-cog"></i></a>
		<a href="LogOut.php" class="links">Wyloguj się</a>
	</div>
	<header id="header">
		<h1>Budżet domowy</h1><h3>Utrzymuj swoje wydatki w ryzach!</h3>
	</header>
	<div id="mainContainer">	
		<nav id="menu">

			<a href="dodaj-wydatki" class="mainMenu">Dodaj wpis</a>
			<div id="expandExps" class="mainMenuActive">Wyświetl wydatki</div>
				<div id="allExps" class="subMenu sub4">Wszystkie</div>
				<div id="byCathegory" class="subMenu sub4">Z wybranej kategorii</div>
				<div id="byPayMeth" class="subMenu sub4">Opłacone wybraną metodą</div>
				<div id="byComment" class="subMenu sub4">Z określonym komentarzem</div>
				<div id="byDate" class="subMenu sub4">Z wybranego okresu</div>
			<a href="wyswietl-podsumowanie" class="mainMenu">Wyświetl podsumowanie</a>
			<a href="edytuj-kategorie" class="mainMenu">Edytuj kategorie</a>
			<a href="edytuj-metody-platnosci" class="mainMenu">Edytuj metody płatności</a>
					
		</nav>

		<main id="mainPage">
			<div id="content" style="display: none;">
			</div>
			<div id="selectCath" class="formEdit" style="display: none;">
				Wyświetl wydatki z kategorii: <br/> 
					<select id="selCath" class="styled-select">
					<?php

						foreach($dataCath as $row)
						{
							echo '<option value=" '.$row['CathegoryID'].' "> '.$row['Name'].' </option>';
						}
										
					?>
					</select><br />
					<input type="submit" value="Zatwierdź" id="buttonCath"> <br />
			</div>
			<div id="selectPayMeth" class="formEdit" style="display: none;">
				Wyświetl wydatki opłacone: <br/> 
					<select id="selPayMeth" class="styled-select">
					<?php

						foreach($dataPayMeth as $row)
						{
							echo '<option value=" '.$row['PayMetID'].' "> '.$row['Name'].' </option>';
						}
										
					?>
					</select><br />
					<input type="submit" value="Zatwierdź" id="buttonPayMeth"> <br />
			</div>
			<div id="selectComment" class="formEdit" style="display: none;">
				Wyświetl wydatki z określonym komentarzem: <br/> 
				<input type="text" id="selComment" placeholder="komentarz" onfocus="this.placeholder="" onblur="this.placeholder="komentarz"/>	
				<input type="submit" value="Zatwierdź" id="buttonComment"> <br />
			</div>
			<div id="selectDate" class="formEdit" style="display: none;">
				Wyświetl wydatki z okresu <br/> 
				od:
				<input type="text" id="startDateText" placeholder="RRRR/MM/DD" onfocus="this.placeholder="" onblur="this.placeholder="RRRR/MM/DD"/>
				do:
				<input type="text" id="endDateText" placeholder="RRRR/MM/DD" onfocus="this.placeholder="" onblur="this.placeholder="RRRR/MM/DD"/> <br />
				<input type="submit" value="Zatwierdź" id="buttonDate"> <br />		
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
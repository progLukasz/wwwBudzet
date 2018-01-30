<?php

	session_start();
		
	if (isset($_POST['expID'])) {
		$_SESSION['expID'] = $_POST['expID'];
	}
	$expID = $_SESSION['expID'];
		
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
					$result1 = $connection->query("SELECT CathegoryID, Name FROM cathegories WHERE UserID = '".$_SESSION['userId']."'");
					$result2 = $connection->query("SELECT PayMetID, Name FROM paymentmethod WHERE UserID = '".$_SESSION['userId']."'");
					$result3 = $connection->query("SELECT c.Name AS cathName, p.Name AS payName, e.Value, e.Date, e.Comment, c.CathegoryID FROM cathegories AS c, paymentmethod AS p, expenses AS e WHERE e.CathegoryID = c.CathegoryID AND e.PayMetID = p.PayMetID AND e.ID = '$expID'");
					$row3 = $result3->fetch_assoc();
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
	
	<script type="text/javascript">

	</script>
</head>

<body onload="colapseMenu('.sub4');">
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
		
			<form class="formEdit" action="EditDBInstance.php" method="post" accept-charset="character_set">
			
				Kategoria wydatku:
				<select name="editCathegory" class="styled-select">
				<?php
					while($row = mysqli_fetch_array($result1))
					{
						echo '<option value="'.$row['CathegoryID'].'"';
						if($row3['cathName'] == $row['Name'])
						{ 
							echo ' selected ';
						};
						echo '>'.$row['Name'].'</option>';
					}					
				?>
				</select><br />
				Koszt:
				<input  type="text" name="editValue" value="<?php echo $row3['Value']; ?>"> PLN<br />
				Rodzaj płatności:
				<select name="editPayMeth" class="styled-select">
				<?php
					while($row = mysqli_fetch_array($result2))
					{
						echo '<option value=" '.$row['PayMetID'].'"';
						if($row3['payName'] == $row['Name'])
						{ 
							echo ' selected ';
						}; 
						echo '> '.$row['Name'].' </option>';
					}	
				?>
				</select><br />
				Data zapłaty:
				<input  type="text" name="editDate" value="<?php echo $row3['Date']; ?>"><br />
				Dodatkowy komentarz:
				<input  type="text" name="editComment" value="<?php echo $row3['Comment']; ?>"><br />
				<?php 
						echo '<input type="hidden" value='.$expID.' name="expID" />';
				?>
				<?php
					if(isset($_SESSION['e_editExpense']))
					{
					echo '<div class="error">'.$_SESSION['e_editExpense'].'</div>';
					unset($_SESSION['e_editExpense']);
					}
					else	echo '<br />';
				?>
				<input type="submit" Value="Zapisz zmiany" name="editInExpenses"> <br />
				
			</form>
		
		</main>
		<span style="clear:both;"></span>
	</div>
	
	
	<footer>
		<div id="info">
		
		</div>
	
	</footer>
	
	
	
</body>

</html>
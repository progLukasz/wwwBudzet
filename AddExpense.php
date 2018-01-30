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
					$result1 = $connection->query("SELECT PayMetID, Name FROM paymentmethod WHERE UserID = '".$_SESSION['userId']."'");
					$result2 = $connection->query("SELECT CathegoryID, Name FROM cathegories WHERE UserID = '".$_SESSION['userId']."'");
					
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

			<div class="mainMenuActive">Dodaj wpis</div>
			<a href=" wyswietl-wydatki" class="mainMenu">Wyświetl wydatki</a>
			<a href="wyswietl-podsumowanie" class="mainMenu">Wyświetl podsumowanie</a>
			<a href="edytuj-kategorie" class="mainMenu">Edytuj kategorie</a>
			<a href="edytuj-metody-platnosci" class="mainMenu">Edytuj metody płatności</a>
					
		</nav>

		<main id="mainPage">
		
			<form class="formEdit" action="AddDBInstance.php" method="post" accept-charset="character_set">
			
				Kategoria wydatku: 
				<select name="cathegory" class="styled-select">
				<?php
					if (isset($_SESSION['savedCathegory']))
					{
						while($row = mysqli_fetch_array($result2))
						{
							echo '<option value="'.$row['CathegoryID'].'"';
							if( $_SESSION['savedCathegory'] == $row['CathegoryID'])
							{ 
								echo ' selected ';
							};
							echo '>'.$row['Name'].'</option>';
						}
					} else {
						while($row = mysqli_fetch_array($result2))
						{
							echo '<option value=" '.$row['CathegoryID'].' "> '.$row['Name'].' </option>';
						}	
					}
					unset($_SESSION['savedCathegory']);		
				?>
				</select><br />
				Koszt:
				<input type="text" name="value" value="<?php if (isset($_SESSION['savedValue'])) { echo $_SESSION['savedValue']; } unset($_SESSION['savedValue']);  ?>"  placeholder="wydana suma" onfocus="this.placeholder="" onblur="this.placeholder="wydana suma"/> PLN<br />
				Rodzaj płatności:
				<select name="paymentMeth" class="styled-select">
				<?php
										
					if (isset($_SESSION['savedPayMeth']))
					{
						while($row = mysqli_fetch_array($result1))
						{
							echo '<option value="'.$row['PayMetID'].'"';
							if( $_SESSION['savedPayMeth'] == $row['PayMetID'])
							{ 
								echo ' selected ';
							};
							echo '>'.$row['Name'].'</option>';
						}
					} else {
						while($row = mysqli_fetch_array($result1))
						{
							echo '<option value=" '.$row['PayMetID'].' "> '.$row['Name'].' </option>';
						}	
					}	
					unset($_SESSION['savedPayMeth']);		
				?>
				</select><br />
				Data zapłaty:
				<input type="text" name="expenseDate" value="<?php if (isset($_SESSION['savedDate'])) { echo $_SESSION['savedDate']; } unset($_SESSION['savedDate']);  ?>" placeholder="RRRR-MM-DD" onfocus="this.placeholder="" onblur="this.placeholder="RRRR-MM-DD"/> <br />
				Dodatkowy komentarz:
				<input type="text" name="comment" value="<?php if (isset($_SESSION['savedComment'])) { echo $_SESSION['savedComment']; } unset($_SESSION['savedComment']);  ?>"  placeholder="opis wydatku - niewymagany" onfocus="this.placeholder="" onblur="this.placeholder="opiswydatku - niewymagany"/> <br />
				<?php
					if(isset($_SESSION['e_addExpense']))
					{
					echo '<div class="error">'.$_SESSION['e_addExpense'].'</div>';
					unset($_SESSION['e_addExpense']);
					}
					else	echo '<br />';
				?>
				<input type="submit" Value="Dodaj do wydatków" name="addToExpenses"> <br />
				
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
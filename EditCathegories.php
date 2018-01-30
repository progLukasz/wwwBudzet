<?php

	session_start();
	
	$pageID = '';
	if(isset($_SESSION['page']))
	{		
		$pageID =  $_SESSION['page'];
		unset ($_SESSION['page']);
	};
			
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
					$result1 = $connection->query("SELECT CathegoryID, Name FROM cathegories WHERE UserID = '".$_SESSION['userId']."'");
					$data   = array();
					while ($row = mysqli_fetch_assoc($result1))
					{
						$data[] = $row;
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
	
	<link rel="stylesheet" href="style.css?version=10 type="text/css" />
	<link href="css/fontello.css" rel="stylesheet" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Audiowide|Caveat|Courgette|Kalam|Vollkorn+SC" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="script.js"></script>
	
	<script type="text/javascript">

		var $page  = "<?php echo $pageID ?>";
		
		$(function(){
			if ($page !='')
			{ 
				$($page).css('display', 'block');
			}
		});
		
			$(function(){
				$('#addCath').click(function(){
				changeContent('#content_1', '#content_2', '#content_3', '#content_4');
				});
			});
			$(function(){
				$('#editCath').click(function(){
				changeContent('#content_2', '#content_1', '#content_3', '#content_4');
				});
			});
			$(function(){
				$('#deleteCath').click(function(){	
				changeContent('#content_3', '#content_1', '#content_2', '#content_4');
				});
			});
			
	</script>

</head>

<body onload="colapseMenu('.sub2');">
	
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
			<div id="expandCath" class="mainMenuActive">Edytuj kategorie</div>
				<div id="addCath" class="subMenu sub2">Dodaj kategorie</div>
				<div id="editCath" class="subMenu sub2">Zmień nazwę kategorii</div>
				<div id="deleteCath" class="subMenu sub2">Usuń kategorię</div>
			<a href="edytuj-metody-platnosci" class="mainMenu">Edytuj metody płatności</a>
						
		</nav>

		<main id="mainPage">
			<div id="content_1" style="display:none;">
				<form class="formEdit" action="EditDBCathegories.php" method="post" accept-charset="character_set">
					Nazwa nowej kategorii:
					<input type="text" name="cathName" placeholder="nazwa" onfocus="this.placeholder="" onblur="this.placeholder="nazwa"/> <br />
					<?php
						if(isset($_SESSION['e_addCath']))
						{
						echo '<div class="error">'.$_SESSION['e_addCath'].'</div>';
						unset($_SESSION['e_addCath']);
						}
						else	echo '<br />';
					?>
					<input type="submit" value="Dodaj kategrię" name="addCathegory"> <br />	
				</form>
			</div>
		
			<div id="content_2" style="display:none;">
				<form class="formEdit" action="EditDBCathegories.php" method="post" accept-charset="character_set">
					Wybierz kategorię, której nazwę chcesz zmienić:
					<select name="cathegoryEdit" class="styled-select">
					<?php
						foreach($data as $row)
						{
							echo '<option value=" '.$row['CathegoryID'].' "> '.$row['Name'].' </option>';
						}					
					?>
					</select><br />
					Nowa nazwa kategorii:
					<input type="text" name="cathNameNew" placeholder="nowa nazwa" onfocus="this.placeholder="" onblur="this.placeholder="nowa nazwa"/> <br />
					<?php
						if(isset($_SESSION['e_editCath']))
						{
						echo '<div class="error">'.$_SESSION['e_editCath'].'</div>';
						unset($_SESSION['e_editCath']);
						}
						else	echo '<br />';
					?>
					<input type="submit" value="Zmień nazwę" name="editCathegory"> <br />
				</form>
			</div>
			
			<div id="content_3" style="display:none;">
				<form class="formEdit" action="EditDBCathegories.php" method="post" accept-charset="character_set">
					Wybierz kategorię, którą chesz usunąć: <br />
					<select name="cathegoryDelete" class="styled-select">
					<?php

						foreach($data as $row)
						{
							echo '<option value=" '.$row['CathegoryID'].' "> '.$row['Name'].' </option>';
						}
										
					?>
					</select><br />
					<?php
						if(isset($_SESSION['e_delCath']))
						{
						echo '<div class="error">'.$_SESSION['e_delCath'].'</div>';
						unset($_SESSION['e_delCath']);
						}	
						else	echo '<br />';
					?>
					<input type="submit" value="Usuń" name="deleteCathegory"> <br />
				</form>
			</div>
			<?php
				if(isset($_SESSION['e_editCathegories']))
				{
				echo '<div class="error">'.$_SESSION['e_editCathegories'].'</div>';
				unset($_SESSION['e_editCathegories']);
				}	
				else	echo '<br />';
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
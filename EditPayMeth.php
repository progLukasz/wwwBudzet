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
					$result1 = $connection->query("SELECT PayMetID, Name FROM paymentmethod WHERE UserID = '".$_SESSION['userId']."'");
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
				$('#addMeth').click(function(){
				changeContent('#content_1', '#content_2', '#content_3', '#content_4');
				});
			});
			
			$(function(){
				$('#editMeth').click(function(){	
				changeContent('#content_2', '#content_1', '#content_3', '#content_4');
				});
			});
			$(function(){
				$('#deleteMeth').click(function(){
				changeContent('#content_3', '#content_1', '#content_2', '#content_4');
				});
			});
	</script>

</head>

<body onload="colapseMenu('.sub3')">
	
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
			<div id="expandMeth" class="mainMenuActive">Edytuj metody płatności</div>
				<div id="addMeth" class="subMenu sub3">Dodaj metodę płatności</div>
				<div id="editMeth" class="subMenu sub3">Zmień nazwę metody płatności</div>
				<div id="deleteMeth" class="subMenu sub3">Usuń metodę płatności</div>
					
		</nav>

		<main id="mainPage">
			<div id="content_1" style="display:none;">
				<form class="formEdit" action="EditDBPayMeth.php" method="post" accept-charset="character_set">
					Nazwa nowej metody płatności:
					<input type="text" name="methName" placeholder="nazwa" onfocus="this.placeholder="" onblur="this.placeholder="nazwa"/> <br />
					<?php		
						if(isset($_SESSION['e_addMeth']))
						{
						echo '<div class="error">'.$_SESSION['e_addMeth'].'</div>';
						unset($_SESSION['e_addMeth']);
						}
						else	echo '<br />';
					?>
					<input type="submit" value="Dodaj metodę płatności" name="addMethod"> <br />	
				</form>
			</div>
			
			<div id="content_2" style="display:none;">
				<form class="formEdit" action="EditDBPayMeth.php" method="post" accept-charset="character_set">
					Wybierz metodę płatości, której nazwę chcesz zmienić:
					<select name="methodEdit" class="styled-select">
					<?php

						foreach($data as $row)
						{
							echo '<option value=" '.$row['PayMetID'].' "> '.$row['Name'].' </option>';
						}
										
					?>
					</select><br />
					Nowa nazwa metody:
					<input type="text" name="methNameNew" placeholder="nowa nazwa" onfocus="this.placeholder="" onblur="this.placeholder="nowa nazwa"/> <br />
					<?php
						if(isset($_SESSION['e_editMeth']))
						{
						echo '<div class="error">'.$_SESSION['e_editMeth'].'</div>';
						unset($_SESSION['e_editMeth']);
						}
						else	echo '<br />';
					?>
					<input type="submit" value="Zmień nazwę" name="editMethod"> <br />
				</form>
			</div>
			
			<div id="content_3" style="display:none;">
				<form class="formEdit" action="EditDBPayMeth.php" method="post" accept-charset="character_set">
					Wybierz metodę płatności, którą chesz usunąć:
					<select name="methodDelete" class="styled-select">
					<?php

						foreach($data as $row)
						{
							echo '<option value=" '.$row['PayMetID'].' "> '.$row['Name'].' </option>';
						}
										
					?>
					</select><br />
					<?php
						if(isset($_SESSION['e_delMeth']))
						{
						echo '<div class="error">'.$_SESSION['e_delMeth'].'</div>';
						unset($_SESSION['e_delMeth']);
						}	
						else	echo '<br />';
					?>
					<input type="submit" value="Usuń" name="deleteMethod"> <br />
				</form>
			</div>
			<div id="content_4" class="formEdit"  style="display:none;">Zadanie zakończone powodzeniem.<br />Wybierz z menu co chciałbyś teraz zrobić</div>
			<?php
				if(isset($_SESSION['e_editMethods']))
				{
				echo '<div class="error">'.$_SESSION['e_editMethods'].'</div>';
				unset($_SESSION['e_editMethods']);
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
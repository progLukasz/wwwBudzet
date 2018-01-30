<?php

	session_start();

	
		require_once "Connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);	//funkcja ta powoduje że nie wyświetlają się żadne poufne dane podczas wyświetlania błędów
		
		if (isset($_SESSION['query'])) {
			$query = $_SESSION['query'];
			unset($_SESSION['query']);
			
			try
			{
				$connection = new mysqli($host, $db_user, $db_password, $db_name);
				if($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$result = $connection->query($query);	
					$connection->close();
					$_SESSION['e_main'] = '<span class="greetingsInfo">Zlecenie zostało wykonane.</span>';
					$_SESSION['backToMain'] = true;
					header('Location: kontroluj-swoje-wydatki');
					exit();
				}		
			}	
			catch(Exception $e)
			{
				$_SESSION['e_main'] = '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
				header('Location: kontroluj-swoje-wydatki');
				exit();
			}
		} else {
			header('Location: kontroluj-swoje-wydatki');
			exit();
		}		
?>
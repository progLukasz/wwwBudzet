<?php

	session_start();

	
		require_once "Connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);	//funkcja ta powoduje że nie wyświetlają się żadne poufne dane podczas wyświetlania błędów
		
		
		$Login = $_SESSION['user'];
		$userID = $_SESSION['userId'];
			try
			{
				$connection = new mysqli($host, $db_user, $db_password, $db_name);
				if($connection->connect_errno!=0)
				{
					throw new Exception(mysqli_connect_errno());
				}
				else
				{
					$connection->query("DELETE FROM expenses WHERE UserID = '$userID' ");
					$connection->query("DELETE FROM cathegories WHERE UserID = '$userID' ");
					$connection->query("DELETE FROM paymentmethod WHERE UserID = '$userID' ");
					$connection->query("DELETE FROM users WHERE Login = '$Login' ");
					$connection->close();
					header('Location: LogOut.php');
					exit();
				}	
			}	
			catch(Exception $e)
			{
				
			}	
		header('Location: budzet-domowy');
				exit();
?>
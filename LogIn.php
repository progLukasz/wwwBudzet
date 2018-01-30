<?php

	session_start();
	
			if((!isset($_POST['login'])) || (!isset($_POST['pass'])))
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
		
			$login = $_POST['login'];
			$password = $_POST['pass'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		
			
			if ($result = $connection->query(sprintf("SELECT * FROM users WHERE Login='%s'",
			 mysqli_real_escape_string($connection, $login))))	
			{
				$usersCount = $result->num_rows;
				if($usersCount>0)
				{
					$row = $result->fetch_assoc();
					
					if(password_verify($password, $row['Password']))
					{
						
						$_SESSION['logged'] = true;
						
						$_SESSION['userId'] = $row['UserID'];
						$_SESSION['user'] = $row['Login'];
						
						unset($_SESSION['blad']);
						
						$result->close();
						header('Location: Main.php');
					}
					else
					{
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span><br/>';
						header('Location: budzet-domowy');
					}
				}
				else
				{
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span><br/>';
					header('Location: budzet-domowy');
				}
			}
			else
			{
				throw new Exception($connection->error);
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
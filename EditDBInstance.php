<?php

	session_start();

	function validateDate($date, $format)
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}	
	
	if(isset($_POST['expID']))
	{
		$valid = true;
		$expID = $_POST['expID'];
		$cost = $_POST['editValue'];
		
		if(strlen($cost)<1)
		{
			$valid = false;
			$_SESSION['e_editExpense'] = "Nie podano kwoty wydatku";
			header('Location: edytuj-wydatki');
			exit();
		}
		
		if(!is_numeric($cost))
		{
			$valid = false;
			$_SESSION['e_editExpense'] = "Podana kwota nie jest wartością liczbową";
			header('Location: edytuj-wydatki');
			exit();
		}
		
		if(strlen($cost)<1)
		{
			$valid = false;
			$_SESSION['e_editExpense'] = "Nie podano kwoty wydatku";
			header('Location: edytuj-wydatki');
			exit();
		}
		
		$payMeth = $_POST['editPayMeth'];
		
		$cathegory = $_POST['editCathegory'];
		
		$date = $_POST['editDate'];
		
		if(strlen($date)<1)
		{
			$valid = false;
			$_SESSION['e_editExpense'] = "Nie podano daty";
			header('Location: edytuj-wydatki');
			exit();
		}
		
		if(!validateDate($date, 'Y-m-d'))
		{
			$valid = false;
			$_SESSION['e_editExpense'] = "Podana data jest niepoprawna";
			header('Location: edytuj-wydatki');
			exit();
		}
		
		$comment = $_POST['editComment'];
		
				
		if($valid == true) {
			
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
					$result = $connection->query("UPDATE expenses  SET CathegoryID='$cathegory', PayMetID='$payMeth', Value='$cost', Date='$date', Comment='$comment' WHERE ID = '$expID'");	
					$connection->close();
					header('Location: wyswietl-wydatki.php');
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
	}				
?>
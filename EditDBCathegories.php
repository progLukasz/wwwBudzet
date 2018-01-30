<?php

	session_start();
	
	require_once "Connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	
	$proceed = true;
	$userID = $_SESSION['userId'];
	if(isset($_POST['addCathegory']))
	{
		$cathName = $_POST['cathName'];
		
		$result = $connection->query("SELECT * FROM cathegories WHERE Name = '$cathName' AND UserID = '$userID' ");
		
		if ($result->num_rows > 0)
		{
			$_SESSION['e_addCath'] = "Dana nazwa kategorii już istnieje";
			$_SESSION['page'] = "#content_1";
			$proceed = false;
		} else if(strlen($cathName)<1)
		{
			$_SESSION['e_addCath'] = "Nie podano nazwy nowej kategorii";
			$_SESSION['page'] = "#content_1";
			$proceed = false;
		} else {
			$userID = $_SESSION['userId'];
			$query = "INSERT INTO cathegories (CathegoryID, Name, UserID) VALUES (NULL, '$cathName', '$userID')";
		}
	}
	else if(isset($_POST['editCathegory']))
	{
		$cathNameID = $_POST['cathegoryEdit'];
		$cathNameNew = $_POST['cathNameNew'];
		
		$result = $connection->query("SELECT * FROM cathegories WHERE Name = '$cathNameNew' AND UserID = '$userID' ");
		
		if ($result->num_rows > 0)
		{
			$_SESSION['e_editCath'] = "Dana nazwa kategorii już istnieje";
			$_SESSION['page'] = "#content_2";
			$proceed = false;
		}else if(strlen($cathNameNew)<1)
		{
			$_SESSION['e_editCath'] = "Nie podano nowej nazwy kategorii";
			$_SESSION['page'] = "#content_2";
			$proceed = false;
		} else if($cathNameID < 1) {
			$_SESSION['e_editCath'] = "Nie wybrano kategorii z listy";
			$_SESSION['page'] = "#content_2";
			$proceed = false;
		} else {
			$query = "UPDATE cathegories SET Name = '$cathNameNew' WHERE CathegoryID = '$cathNameID'";
		}		
	}
	else if(isset($_POST['deleteCathegory']))
	{
		$cathNameID = $_POST['cathegoryDelete'];
		
		$result = $connection->query("SELECT * FROM expenses WHERE CathegoryID = '$cathNameID' UserID = '$userID' ");
		if($result->num_rows > 0)
		{
			$_SESSION['e_delCath'] = "Nie można usunąć danej kategorii, gdyż jest ona przypisana do co najmniej jednego wpisu.";
			$_SESSION['page'] = "#content_3";
			$proceed = false;
		} else {
			if($cathNameID < 1) 
			{
				$_SESSION['e_delCath'] = "Nie wybrano kategorii do usunięcia";
				$_SESSION['page'] = "#content_3";
				$proceed = false;
			} else {
				$query = "DELETE FROM cathegories WHERE CathegoryID = '$cathNameID'";
			}
		}
		$connection->close();
	}
	
	if ($proceed == true)
	{
		$_SESSION['query'] = $query;
		header('Location: Querying.php');
		exit();
	} else {
		header('Location: edytuj-kategorie');
		exit();
	}
				
?>
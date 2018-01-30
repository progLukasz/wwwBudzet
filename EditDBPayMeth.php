<?php

	session_start();

	require_once "Connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	$connection = new mysqli($host, $db_user, $db_password, $db_name);
	
	$proceed = true;
	
	if(isset($_POST['addMethod']))
	{
		$methName = $_POST['methName'];
		
		$result = $connection->query("SELECT * FROM paymentmethod WHERE Name = '$methName' AND UserID = '$userID' ");
		
		if ($result->num_rows > 0)
		{
			$_SESSION['e_addMeth'] = "Dana nazwa metody płatności już istnieje";
			$_SESSION['page'] = "#content_1";
			$proceed = false;
		} else if(strlen($methName)<1)
		{
			$_SESSION['e_addMeth'] = "Nie podano nazwy nowej metody";
			$_SESSION['page'] = "#content_1";
			$proceed = false;
		} else {
			$userID = $_SESSION['userId'];
			$query = "INSERT INTO paymentmethod (PayMetID, Name, UserID) VALUES (NULL, '$methName', '$userID')";
		}
	}
	else if(isset($_POST['editMethod']))
	{
		$methNameID = $_POST['methodEdit'];
		$methNameNew = $_POST['methNameNew'];
		
		$result = $connection->query("SELECT * FROM paymentmethod WHERE Name = '$methNameNew' AND UserID = '$userID' ");
		
		if ($result->num_rows > 0)
		{
			$_SESSION['e_editMeth'] = "Dana nazwa metody płatności już istnieje";
			$_SESSION['page'] = "#content_2";
			$proceed = false;
		} else if(strlen($methNameNew)<1)
		{
			$_SESSION['e_editMeth'] = "Nie podano nowej nazwy metody";
			$_SESSION['page'] = "#content_2";
			$proceed = false;
		} else if($methNameID < 1) {
			$_SESSION['e_editMeth'] = "Nie wybrano metody z listy";
			$_SESSION['page'] = "#content_2";
			$proceed = false;
		} else {
			$query = "UPDATE paymentmethod SET Name = '$methNameNew' WHERE PayMetID = '$methNameID'";
		}		
	}
	else if(isset($_POST['deleteMethod']))
	{
		$methNameID = $_POST['methodDelete'];
		
		
		$result = $connection->query("SELECT * FROM expenses WHERE PayMetID = '$methNameID' AND UserID = '$userID' ");
		if($result->num_rows > 0)
		{
			$_SESSION['e_delMeth'] = "Nie można usunąć danej metody płatności, gdyż jest ona przypisana do co najmniej jednego wpisu.";
			$_SESSION['page'] = "#content_3";
			$proceed = false;
		} else {
			if($methNameID < 1) 
			{
				$_SESSION['e_delMeth'] = "Nie wybrano metody do usunięcia";
				$_SESSION['page'] = "#content_3";
				$poceed = false;
			} else {
				$query = "DELETE FROM paymentmethod WHERE PayMetID = '$methNameID'";
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
		header('Location: edytuj-metody-platnosci');
		exit();
	}
				
?>
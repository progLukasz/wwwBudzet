<?php

	session_start();
	
	$startDate = $_POST['startDate'];
	$endDate = $_POST['endDate'];

	require_once "Connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);	//funkcja ta powoduje że nie wyświetlają się żadne poufne dane podczas wyświetlania błędów

	try
	{
		$connection = new mysqli($host, $db_user, $db_password, $db_name);
		if($connection->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
			
			$result1 = $connection->query("SELECT * FROM cathegories WHERE UserID = ".$_SESSION['userId']);	
					
			$cathegories = array();
			while ($row = mysqli_fetch_assoc($result1))
			{
				$cathegories[] = $row;
			}
			
			$howManyCath = $result1->num_rows;	
			
			$cathNames = array($howManyCath);
			$cathSummary = array($howManyCath);
			$iteration = 0;
			foreach($cathegories as $row)
				{
					$cathID = $row['CathegoryID'];
					$result2 = $connection->query("SELECT Name FROM cathegories WHERE CathegoryID = '$cathID'");
					$result3 = $connection->query("SELECT SUM(Value) FROM expenses WHERE CathegoryID = '$cathID' AND Date BETWEEN '$startDate' AND '$endDate'");
					
					$cathNames[$iteration] =$result2->fetch_row();
					$cathSummary[$iteration] = $result3->fetch_row();
					
					$iteration = $iteration + 1;
				}					
			$connection->close();
				
		}
		if(!$result1) throw new Exception($connection->error);
		if(!$result2) throw new Exception($connection->error);
	}	
	catch(Exception $e)
	{
		echo  '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
	}
	
?>

<body>
	<canvas id="pie-chart" width="800" height="450"></canvas>
	<script>
		
		var iArray= <?php echo json_encode($cathNames); ?>;
		var jArrayStr= <?php echo json_encode($cathSummary); ?>;
		var jArray = jArrayStr.map(Number);
	
		new Chart(document.getElementById("pie-chart"), {
			type: 'pie',
			data: {
			  labels: iArray,
			  datasets: [{
				label: 'Wydatki wg kategorii [zł]',
				backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#30952d", "#0d1bbc","#fc0724","#d861ca","#b7aa58","#346d40","#e0a34e","#43a0a0","#938d14","#921414"],
				data: jArray
			  }]
			},
			options: {
			  title: {
				display: true,
				text: 'Wydatki wg kategorii [zł]'
			  }
			}
		});
	</script>
</body>

			
					
					
					
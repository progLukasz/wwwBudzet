<?php

	session_start();

	require_once "Connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);	//funkcja ta powoduje że nie wyświetlają się żadne poufne dane podczas wyświetlania błędów

	$sortedBy = $_POST['sortedBy'];
	
	if  ($sortedBy == 'all')
	{
		$query= "SELECT c.Name AS cathName, p.Name AS payName, e.Value, e.Date, e.Comment, e.ID FROM cathegories AS c, paymentmethod AS p, expenses AS e WHERE e.CathegoryID = c.CathegoryID AND e.PayMetID = p.PayMetID AND e.UserID = ".$_SESSION['userId'];
	} else if ($sortedBy == 'cathegory')
	{
		$display = $_POST['display'];
		$query= "SELECT c.Name AS cathName, p.Name AS payName, e.Value, e.Date, e.Comment, e.ID FROM cathegories AS c, paymentmethod AS p, expenses AS e WHERE e.CathegoryID = c.CathegoryID AND e.PayMetID = p.PayMetID AND e.UserID = ".$_SESSION['userId']." AND e.CathegoryID = '$display'";
	} else if ($sortedBy == 'payMeth')
	{
		$display = $_POST['display'];
		$query= "SELECT c.Name AS cathName, p.Name AS payName, e.Value, e.Date, e.Comment, e.ID FROM cathegories AS c, paymentmethod AS p, expenses AS e WHERE e.CathegoryID = c.CathegoryID AND e.PayMetID = p.PayMetID AND e.UserID = ".$_SESSION['userId']." AND e.PayMetID = '$display'";
	} else if ($sortedBy == 'comment')
	{
		$display = $_POST['display'];
		$query= "SELECT c.Name AS cathName, p.Name AS payName, e.Value, e.Date, e.Comment, e.ID FROM cathegories AS c, paymentmethod AS p, expenses AS e WHERE e.CathegoryID = c.CathegoryID AND e.PayMetID = p.PayMetID AND e.UserID = ".$_SESSION['userId']." AND e.Comment = '$display'";
	} else if ($sortedBy == 'date')
	{
		$startDate = $_POST['startDate'];
		$endDate = $_POST['endDate'];
		$query= "SELECT c.Name AS cathName, p.Name AS payName, e.Value, e.Date, e.Comment, e.ID FROM cathegories AS c, paymentmethod AS p, expenses AS e WHERE e.CathegoryID = c.CathegoryID AND e.PayMetID = p.PayMetID AND e.UserID = ".$_SESSION['userId']." AND e.Date BETWEEN '$startDate' AND '$endDate'";
	} 
	
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
				
		}
		if(!$result) throw new Exception($connection->error);
	}	
	catch(Exception $e)
	{
		echo  '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
	}
	
?>
<head>
	<script>
	
		$(document).ready(function(){
	
			$.extend(
			{
				redirectPost: function(location, args)
				{
					var form = $('<form></form>');
					form.attr("method", "post");
					form.attr("action", location);

					$.each( args, function( key, value ) {
						var field = $('<input></input>');

						field.attr("type", "hidden");
						field.attr("name", key);
						field.attr("value", value);

						form.append(field);
					});
					$(form).appendTo('body').submit();
				}
			});
		
		
		
			$('.delete').click(function(){
				var element = this;
				var id = this.id;
				var splitId = id.split("_");

				var deleteId = splitId[1];
				 
				$.ajax({
					url: 'DelExpense.php',
					type: 'POST',
					data: { id:deleteId },
					success: function(response){

						$(element).closest('tr').css('background','green');
						$(element).closest('tr').fadeOut(800, function(){ 
							$(this).remove();
						});
					}
				 });
			});
			
			$('.edit').click(function(){
				var element = this;
				var id = this.id;
				var splitId = id.split("_");
				var editId = splitId[1];
				$.redirectPost('edytuj-wydatki', { expID : editId });
			});
		});
	
	</script>
</head>
<body>
	<form id="formExpenses" name="form" method="post" action="confirm.php">
		<table border='1' cellspacing='0' width='800' id='expTable'>
		  <tr>
			<th bgcolor='green'><font color='white'>Kategoria</font></th>
			<th bgcolor='green'><font color='white'>Metoda płatności</font></th>
			<th bgcolor='green'><font color='white'>Wartość [zł]</font></th>
			<th bgcolor='green'><font color='white'>Data</font></th>
			<th bgcolor='green'><font color='white'>Komentarz</font></th>
			<th bgcolor='green'><font color='white'>Edytuj wpis</font></th>
			<th bgcolor='green'><font color='white'>Usuń wpis</font></th>
		  </tr>
		  
			<?php
				$i = 0;
				$number = 0;
				while($row = mysqli_fetch_array($result)) {
		 
					$number++; 
					$i++;
					if($i%2)
					{
						$bg_color = "#EEEEEE";
					}
					else 
					{
						$bg_color = "#E0E0E0";
					}   
			   
					echo "<tr bgcolor=".$bg_color.">";
					echo "<td><center><Strong>".$row['cathName']."</Strong></center></td>";
					echo "<td><center><Strong>".$row['payName']."</Strong></center></td>";
					echo "<td><center><Strong>".$row['Value']."</Strong></center></td>";
					echo "<td><center><Strong>".$row['Date']."</Strong></center></td>";
					echo "<td><center><Strong>".$row['Comment']."</Strong>";
					echo "<td><div class='edit' id='edit_".$row['ID']."'>Edytuj</div></td>";
					echo "<td><div class='delete' id='del_".$row['ID']."'>Usuń</div></td>";
					echo "</tr>";
				} 
			 ?>
		</table>
	</form>
</body>

			
					
					
					
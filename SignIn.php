<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	session_start();

	if(isset($_POST['emailNew']))
	{
		$valid = true;
		
		$nick = $_POST['loginNew'];
		
		if((strlen($nick)<3) || (strlen($nick)>20))
		{
			$valid = false;
			$_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";
		}

		if(ctype_alnum($nick)==false)
		{
			$valid = false;
			$_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}

		$email = $_POST['emailNew'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
		{
			$valid = false;
			$_SESSION['e_email'] = "Podaj poprawny adres email!";
		}
		
		$password1 = $_POST['passNew1'];
		$password2 = $_POST['passNew2'];
		
		if((strlen($password1)<8) || (strlen($password1)>20))
		{
			$valid = false;
			$_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków!";
		}
		
		if($password1 != $password2)
		{
			$valid = false;
			$_SESSION['e_password'] = "Podane hasła różnią się od siebie!";
		}	
		
		$hashedPass = password_hash($password1, PASSWORD_DEFAULT);
		
		if(!isset($_POST['terms']))
		{
			$valid = false;
			$_SESSION['e_terms'] = "Potwierdź akceptację regulaminu";
		}		
		
		$secretKey = '6LdsfzoUAAAAAEYWRIGW2vtjwd1CO_wSFUwVMF33';
		$checkCaptcha = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
		
		$answer = json_decode($checkCaptcha);
		
		if(!($answer->success))
		{
			$valid = false;
			$_SESSION['e_bot'] = "Potwierdź że nie jesteś botem";
		}
		
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
				$result = $connection->query("SELECT UserID FROM users WHERE Email = '$email'");
				
				if(!$result) throw new Exception($connection->error);
				
				$howManyEmails = $result->num_rows;
				
				if($howManyEmails>0)
				{
					$valid = false;
					$_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu email";
				}
				
				$result = $connection->query("SELECT UserID FROM users WHERE Login = '$nick'");
				
				if(!$result) throw new Exception($connection->error);
				
				$howManyEmails = $result->num_rows;
				
				if($howManyEmails>0)
				{
					$valid = false;
					$_SESSION['e_nick'] = "Istnieje już konto o takiej nazwie! Wybierz inną.";
				}
				
				
				if($valid == true)
				{
					$token = md5($nick.time());
				
					if ($connection->query("INSERT  INTO unactivatedusers VALUES (NULL, '$token', '$nick', '$email', '$hashedPass')"))
					{
															$mail = new PHPMailer(true);
	
															try{
																$mail->setLanguage('pl');
																$mail->isSMTP(); // telling the class to use SMTP
																$mail->SMTPDebug = 2;
																$mail->Host = 's51.linuxpl.com';
																$mail->Port = 587; 
																$mail->SMTPSecure = 'tls'; 
																//$mail->Mailer = 'smtp';
																$mail->SMTPAuth = true; 
																$mail->Username = 'admin@lukaszwojciech.it'; 
																$mail->Password = 'Miszczu87'; 
															
																// Typical mail data
																$mail->setFrom( 'admin@lukaszwojciech.it', 'budzet.lukaszwojciech.it');
																$mail->addAddress($email, $nick);
																$mail->Subject = 'Aktywacja konta na stronie BudzetDomowy.pl';
																$mail->Body = 'Witaj '.$nick.',<br><br>Prosze kliknac na ponizszy link aktywacyjny aby dokonczyc tworzenie konta na stronie Budzet Domowy<br> <a href="http://budzet.lukaszwojciech.it/Activate.php?token='.$token.'">http://budzet.lukaszwojciech.it/Activate.php?token='.$token.'</a><br><br>Z powazaniem<br>Zespol budzet.lukaszwojciech.it';
																$mail->IsHTML(true);  
																$mail->Send();
																//$mail->ErrorInfo;
																//echo "Success!";
																
															} catch(Exception $e){
																// Something went bad
																$mail->ErrorInfo;
																echo $e;
																echo "Fail :(";
															}
															header('Location: WaitForEmail.php');
																exit();
					}
					else
					{
						throw new Exception($connection->error);
					}
				
				}
				else
				{
					header('Location: budzet-domowy');
					exit();
				}
				
					
				$connection->close();
			}
		}
		catch(Exception $e)
		{
			$_SESSION['e_server'] = '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie.</span>';
			header('Location: budzet-domowy');
			exit();
		}
		
	}


?>
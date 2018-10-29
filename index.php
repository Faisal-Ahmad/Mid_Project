<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<style>
			.error{color:red;}
			.text{font-size:30px;}
			table{border:1px solid black;}
			td{padding:20px;}
			input[type=text]
			{
				font-size:20px;
			}input[type=password]
			{
				font-size:20px;
			}
			input[type=submit]
			{
				font-size:20px;
			}
			input[type=reset]
			{
				font-size:20px;
			}
		</style>
	</head>
	<body>
	<?php
		session_start();
	
		$email = $emailErr = $password =$passErr ="";
		$usertype=$username=null;
		$femail = $fpass=1;
		$okpass = $okemail =0;
		function test_input($data) 
		{
		  $data = trim($data);
		  $data = stripslashes($data);
		  return $data;
		}
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			if (empty($_POST["email"])) 
			{
				$femail=0;
				$emailErr = "Email is required";
			}
			else 
			{
			$email = test_input($_POST["email"]);
			}
			if (empty($_POST["pass"])) 
			{
				$femail=0;
				$passErr = "Password is required";
			}
			else 
			{
			$password = test_input($_POST["pass"]);
			}
			if($femail==1 && $fpass==1)
			{
				$xml=simplexml_load_file("Userdata.xml") or die("Error: Cannot Open File");
				foreach($xml->children() as $info) {
				foreach($info->children() as $data)
				{
					if($data->email == $email && $data->password == $password)
					{
						
						$okemail=1;
						$okpass=1;
						$usertype=$info->getName();
					$username = $data->name;
					}
					
					
				}
				}
				if($okemail==0)
				{
					$emailErr = "User Not Exist";
				}
				if($okemail==1 && $okpass==1)
				{
					if($usertype=="student")
					{
						$_SESSION["student"]=$username;
						header("location:Student.php");
					}
					else
					{
						$_SESSION["teacher"]=$username;
						header("location:Teacher.php");
					}
				}
			}
		}
	?>
		<form name="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<br/><br/><br/>
			<table align="center">
				<tr>
					<td>
					<span class="text">Email :</span>
					</td>
					<td>
						<input type="text" name="email" size="25px" value="<?php echo $email;?>"/>
						<span class="error">* <?php echo $emailErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
					<span class="text">Password :</span>
					</td>
					<td>
						<input type="password" name="pass" size="25px" value="<?php echo $password;?>">
						<span class="error">* <?php echo $passErr;?></span>
					</td>
				</tr>
				
				<tr>
					<td>
					</td>
					<td>
						<input type="submit" value="SignIn">
						<input type="reset" value="Clear">
					</td>
				</tr>
				<tr>
					<td colspan="2">
					<span class="text">If you have no account <a href="Registration.php">Signup Here</a></span>
					</td>
				</tr>
		</table>
	</body>
</html>
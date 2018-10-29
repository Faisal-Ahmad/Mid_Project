<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<style>
		.error{color:red;} 
		.text{font-size:30px;}
		table
		{
			background:rgb(30,30,50,0.6);
			padding:30px;
		}
		td
		{
			padding:20px;
		}
		body 
		{
			background-image: url("background.jpg");
			background-repeat: no-repeat;
		}
		input[type=text]
		{
			font-size:20px;
		}
		input[type=password]
		{
			font-size:20px;
		}
		input[type=submit]
		{
			font-size:25px;
		}
		input[type=reset]
		{
			font-size:25px;
		}
		input[type=radio]
		{
			font-size:20px;
		}
		select
		{
			font-size:25px;
		}
		</style>
	</head>
	<body>
<?php
$nameErr  = $emailErr = $typeerr  = $passErr  = $iderr ="";
$name = $email = $type = $password = $id="";
$fname = $femail = $ftype =$fpassword =$fid =1;

function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  return $data;
	}
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (empty($_POST["un"])) {
    $nameErr = "Username is required";
	$fname=0;
  } else {
    $name = test_input($_POST["un"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
		$fname=0;
      $nameErr = "Only letters and white space allowed";
    }
  }
   if (empty($_POST["id"])) {
	   $fid=0;
    $iderr = "ID is required";
  } else {
    $id = test_input($_POST["id"]);
    }
  if (empty($_POST["ue"])) {
	  $femail=0;
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["ue"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
	  $femail=0;
    }
  }
   if (empty($_POST["pw"])) {
    $passErr = "Password is required";
	$fpassword=0;
  } else {
    $password = test_input($_POST["pw"]);
    if (!preg_match("/^[a-zA-Z0-9]{6}/", $password)) {
      $passErr = "password is too short";
	  $fpassword=0;
    }
  }
  if (empty($_POST["type"])) {
    $typeerr = "Type is required";
	$ftype=0;
  } else {
    $type = test_input($_POST["type"]);
  }
  if($fname==1 && $fid==1 && $femail==1 && $fpassword==1 && $ftype==1)
  {
	$filename="Userdata.xml";
	if(filesize($filename)==0)
	{
		$xml =new XMLWriter();
		$xml->openMemory();
		$xml->setIndent(true);
		$xml->startDocument('1.0', 'UTF-8');
		$xml->startElement('users');
		$xml->startElement($type);
		$xml->startElement("info");
		$xml->writeElement("name",$name);
		$xml->writeElement("id",$id);
		$xml->writeElement("email",$email);
		$xml->writeElement("password",$password);
		$xml->endElement();
		$xml->endElement();
		$xml->endDocument();
		$file = $xml->outputMemory();
		file_put_contents($filename,$file,FILE_APPEND);
	}
	else{
		$dom = new DOMDocument();
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->load($filename);
		
		
		if($found = $dom->getElementsByTagName($type)[0])
		{
			$element = $dom->createElement('info');
			$element1 =  $dom->createElement("name", $name);
			$element2 = $dom->createElement("id", $id);
			$element3 =  $dom->createElement("email", $email);
			$element4 =  $dom->createElement("password", $password);
			$element->appendChild($element1);
			$element->appendChild($element2);
			$element->appendChild($element3);
			$element->appendChild($element4);
			$found->appendChild($element);
			$dom->save($filename);
		}
		else{
			$found = $dom->createElement($type);
			$element = $dom->createElement('info');
			$element1 =  $dom->createElement("name", $name);
			$element2 = $dom->createElement("id", $id);
			$element3 =  $dom->createElement("email", $email);
			$element4 =  $dom->createElement("password", $password);
			$element->appendChild($element1);
			$element->appendChild($element2);
			$element->appendChild($element3);
			$element->appendChild($element4);
			$found->appendChild($element);
			$dom->documentElement->appendChild($found); 
			$dom->save($filename);
		}
	}
	header("location:index.php");
  }
}
?>
		<form name="registration" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<br/><br/><br/>
			<table align="center">
				<tr>
					<td>
					<input type ="text" name ="un" placeholder="Name" size="30px" value="<?php echo $name;?>"/>
					<span class="error">* <?php echo $nameErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
					 <input type ="text" name ="id" size="30px" placeholder="ID" value="<?php echo $id;?>"/>
					 <span class="error">* <?php echo $iderr;?></span>
					</td>
				</tr>
				<tr>
					<td>
					 <input type ="text" name ="ue" size="30px" placeholder="Email" value="<?php echo $email;?>"/>
					 <span class="error">* <?php echo $emailErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
					 <input type ="password" name ="pw" size="30px" placeholder="Password" value="<?php echo $password;?>"/>
					 <span class="error">* <?php echo $passErr;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<select name="type">
							<option disabled selected>User Type</option>
							<option value="student" <?php if (isset($type) && $type=="student") echo "checked";?>>Student</option>
							<option value="teacher" <?php if (isset($type) && $type=="teacher") echo "checked";?>>Teacher</option>
					    </select>
						<span class="error">* <?php echo $typeerr;?></span>
					</td>
				</tr>
				<tr>
					<td>
					<input type="submit" value="SignUp">
					<input type="reset" value="Back" onclick="location.href='index.php '">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
					 
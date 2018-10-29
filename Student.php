<?php

session_start();
echo session_id() .'</br>';;
echo "027kh3pshv147k4uvpak6g7jfc".'</br>';
var_dump($_SESSION);
/*if(!isset($_SESSION["student"])) {
     header("location:index.php");
} else { 
    echo "<h1>Welcome ".$_SESSION["student"]."</h1>";
	//echo "<a href ='sclose.php'>Logout</a>";//go to sclose page
}*/
?>
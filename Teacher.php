<?php
session_start();
if(!isset($_SESSION["teacher"])) {
     header("location:index.php");
} else { 
    echo "<h1>Welcome ".$_SESSION["teacher"]."</h1>";
	//echo "<a href ='sclose.php'>Logout</a>";//go to sclose page
}
?>
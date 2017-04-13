<?
if(!session_id()) session_start();

$username = $_SESSION["username"];

if (!isset($username)) {

	header("location: https://ppaa.fisip.ui.ac.id/remun/index.php");
	#?><meta http-equiv=”refresh” content=”1;url=https://ppaa.fisip.ui.ac.id/remun/index.php”><?
	
}

?>
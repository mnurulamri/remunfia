<?
if(!session_id()) session_start();
if(empty($_SESSION['username']))	header("Location:index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Absensi Pengajar <? echo $_SESSION["programstudi"];?></title>
</head>
<body bgcolor="#eee">
<?
include("menu.php")
?>
<br><br>
<strong><font color="gray" face="arial">Silahkan gunakan Mozilla Firefox untuk kenyamanan tampilan...</font></strong>
<div style="margin-bottom:50px">
<?//include 'footer.php'?>
</div>
</body>
</html>


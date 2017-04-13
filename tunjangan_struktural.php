<?
if(!session_id()) session_start();
if(empty($_SESSION['username']))	header("Location:index.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php include("menu.php"); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Tunjangan Struktural</title>
        <!-- Mengincludekan JQueryUI CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/sunny/jquery-ui-1.8.16.custom.css" />
        <!-- Mengincludekan CSS Jqgrid -->
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/ui.jqgrid.css" />
		
		<!-- Sedikit CSS agar lebih bagus -->
		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/pemanis.css" />
		
        <!-- Mengincludekan Library Jquery -->
		<script src="jqgrid/js/jquery-1.5.2.min.js" type="text/javascript"></script>
		
		<!-- Library Jquery UI untuk mempercantik Button2 nya -->
		<!-- Mengincludekan Library Jquery UI-->
		<script src="jqgrid/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>

		<link rel="stylesheet" type="text/css" media="screen" href="jqgrid/css/center.css" />
		
		<!-- Mengincludekan Locale untuk JQGrid -->
		<script src="jqgrid/js/i18n/grid.locale-en.js" type="text/javascript"></script>
        <!-- Mengincludekan Library untuk JQGrid -->
		<script src="jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
	
		<script src="tunjangan_struktural_data.js" type="text/javascript"> </script>
	</head>
	<body  style="background:#336666">
		<br><br>
		<div style="margin-left: auto; margin-right: auto; text-align:center">
			<a href="tunjangan_struktural_input.php" class="add" ><input type="button" id="AddButton" class="button" value="Tambah Data" ></a>
		</div>	
		<div id="formInput"></div>		
		<br/>
		<table id="list2" class="scroll" cellpadding="0" cellspacing="0"></table>
		<div id="pager2" class="scroll" style="text-align:center;"></div>
		<br/>		
	</body>
</html>
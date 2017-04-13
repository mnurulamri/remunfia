<?
include("conn.php");
include("menu.php");
$query = "select programstudi, ketuaprogramstudi from organisasi where ketuaprogramstudi <> ''";
$result = mysql_query($query) or die ("Pesan Error : ".mysql_error());

$html = "<table id='mytable'><th>Program Studi</th><th>Ketua Program Studi</th>";
while($rows = mysql_fetch_array($result)){
	$html .= "<tr><td>".$rows['programstudi']."</td><td>".$rows['ketuaprogramstudi']."</td></tr>";
}
$html .= "</table>";
print $html;
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Bimbingan dan Insentif</title>
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
		<!--<script src="jqgrid/tbltogrid.js" type="text/javascript"> </script>-->
	</head>

	<script>
		tableToGrid("#mytable");
		$('#mytable').jqGrid({
			rowNum: 100,
			pager: '#pager',
			rowList: [10,20,30]
		});
	</script>
<html>
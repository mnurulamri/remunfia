<?
if(!session_id()) session_start();
if(empty($_SESSION['username'])) header("Location:index.php");

include("conn.php");
include("menu.php");

$query = "SELECT distinct departemen, program, ketuaprogramstudi 
		  FROM organisasi 
		  WHERE ketuaprogramstudi <> ''		  
		  GROUP BY departemen, program, ketuaprogramstudi
		  ORDER BY substr(kodeorganisasi,4,2), substr(kodeorganisasi,1,2)";
$result = mysql_query($query) or die(mysql_error());

while ($row = mysql_fetch_object($result)){
	$data[$row->departemen][] = $row;
}

$html = "";
$i = 1;

foreach($data as $departemen => $records){
	$html .= "<div id='tabs-".$i."' style='width:50%; margin-top:20px; margin-left: auto; margin-right: auto; text-align:center;'><table class='gridtable' border='1'><tr><th>Program</th><th>Ketua Program</th></tr>";
	foreach($records as $baris){
		$html .= "<tr><td>".$baris->program."</td><td>".$baris->ketuaprogramstudi."</td></tr>";		
	}
	$html .= "</table></div>";
	$i += 1;
}

?>

		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Pejabat Program Studi</title>
		<link type="text/css" href="js/jquery-ui-1.8.18.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
		<script src="js/jquery.ui.core.js"></script>
		<script src="js/jquery.ui.widget.js"></script>
		
		<!--<script type="text/javascript" src="js/jquery.effects.blind.js"></script>-->
		<script type="text/javascript">
			$(function(){
				// Tabs
				/*$('#tabs').tabs({
					show: {effect:'slide', duration:800}
				});*/
				$('#tabs').tabs();
			});
		</script>
		<style type="text/css">
			/*demo page css*/
			#tabs { font: 80% "Trebuchet MS", sans-serif; margin-top: 20px; margin-left:auto; margin-right:auto; width:82.7%;}
			
			
			/* table */
			table.gridtable {
				font-family: verdana,arial,sans-serif;
				font-size:11px;
				color:#333333;
				border-width: 1px;
				border-color: #666666;
				border-collapse: collapse;
				margin-left:auto;
				margin-right:auto;
			}
			table.gridtable th {
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #dedede;
			}
			table.gridtable td {
				text-align:left;
				border-width: 1px;
				padding: 8px;
				border-style: solid;
				border-color: #666666;
				background-color: #ffffff;
			}
		</style>	
	</head>
	<body style="background-color:#336666">
	
		<!-- Tabs -->
		<div class="ui-widget">
			<div class="ui-state-highlight ui-corner-all" style="margin-left: auto; margin-right:auto; margin-top:30px; padding: 0 .7em; width:30%; text-align:center;"> 
				<p>Pejabat Program Studi</p>
			</div>
		</div>
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Ilmu Komunikasi</a></li>
				<li><a href="#tabs-2">Ilmu Politik</a></li>
				<li><a href="#tabs-3">Ilmu Administrasi</a></li>
				<li><a href="#tabs-4">Sosiologi</a></li>
				<li><a href="#tabs-5">Kriminologi</a></li>
				<li><a href="#tabs-6">Ilmu Kesejahteraan Sosial</a></li>
				<li><a href="#tabs-7">Antropologi</a></li>
				<li><a href="#tabs-8">Ilmu Hubungan Internasional</a></li>
			</ul>
			<?print $html?>
		</div>
	
	</body>
</html>



<? 
if(!session_id()) session_start();
include 'conn.php';
$username = $_SESSION["username"];
$hak_akses = $_SESSION["hak_akses"];

function display_children($parent, $level, $hak_akses) {
	$sql = "SELECT a.id, a.label, a.link, Deriv1.Count
			FROM `menu` a LEFT OUTER JOIN (
				SELECT parent, COUNT(*) AS Count FROM `menu` GROUP BY parent)
			Deriv1 ON a.id = Deriv1.parent
			WHERE a.parent = $parent AND `".$hak_akses."` = 1
			ORDER BY sort";
	$result = mysql_query($sql);
	echo "<ul>";
	while ($row = mysql_fetch_assoc($result)) {
		if ($row['Count'] > 0) {
			echo "<li><a href='" . $row['link'] . "'>" . $row['label'] . "</a>";
			display_children($row['id'], $level + 1, $hak_akses);
			echo "</li>";
		} elseif ($row['Count']==0) {
			if($row['label'] == "SK Remun"){
				echo "<li><a href='" . $row['link'] . "' target='_blank'>" . $row['label'] . "</a></li>";
			} else {
				echo "<li><a href='" . $row['link'] . "'>" . $row['label'] . "</a></li>";
			}
		} else;
	}
	echo "</ul>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<link rel="icon" type="image/ico" href="Rupiah.ico"></link>
<link rel="shortcut icon" href="images/Rupiah.ico"></link>
<? 
if(!session_id()) session_start();
$username = $_SESSION["username"];
if(!isset($_SESSION['username']) || empty($_SESSION['username']))	header("Location:index.php");
?>

<link href="menu.css" media="screen, projection" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.js"></script>
<script src="js/jquery.countdown360.min.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
<div style="background: #000 url(images/logo_ui_horizontal_no_frame_fordarkbackground.png) no-repeat 0 0 fixed ; background-size: 190px 50px; width:100%; height: 52px; text-align:right; color:white;">
<!-- <div style="width:100%; height: 90px; text-align:right; color:white; background:#fff">
	<div style="height:20px"></div> -->
	<div style=" padding-top:5px">
		<font size="2" face="fantasy" style="color:#ccc;">Fakultas Ilmu Admnistrasi&nbsp;&nbsp;</font>
	</div>
	<div style="padding-top:5px; padding-bottom:5px">
		<font face="fantasy" size="2" style="margin-left:16px; color:#ccc"><?echo $_SESSION['programstudi']?>&nbsp;&nbsp;</font>		
	</div>
	<!--<h2 style="text-align:right; padding-top:22px; color:darkorange;"><font size="3" face="arial"><marquee WIDTH="21%">Pusat Pelayanan Administrasi Akademik (PPAA)</marquee></font></h2>-->
		<div style="display:table; width:100%; height:100%;" >		
			<div style="display:table-row;">
				<div id="container" style="display:table-cell;">
					<div id="countdown"></div>
					<script type="text/javascript" charset="utf-8">					
					var clock = $("#countdown").countdown360({
						radius      : 15,
						seconds     : 1400,
						fontColor   : "#FFF380",
						fillStyle	: "#FFF380",
						strokeStyle	: "rgb(237,67,55)", //#FFDB58
						fontWeight	: 200,
						autostart   : false,
						onComplete  : function () { console.log("done");  window.location = "logout.php";}
					});
					clock.start()
					</script>
				</div>
				<div style="display:table-cell; width:20px"></div>				
			</div>
		</div>		
</div>
<!-- <div style="background: url(images/headerui2_.png); text-align:left; height:25px; border: 1px solid red"> -->
<div style="text-align:center; background: rgb(203,96,179); /* Old browsers */
background: -moz-linear-gradient(top, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 0%, rgba(168,0,119,1) 100%, rgba(219,54,164,1) 100%, rgba(168,0,119,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, rgba(203,96,179,1) 0%,rgba(193,70,161,1) 0%,rgba(168,0,119,1) 100%,rgba(219,54,164,1) 100%,rgba(168,0,119,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, rgba(203,96,179,1) 0%,rgba(193,70,161,1) 0%,rgba(168,0,119,1) 100%,rgba(219,54,164,1) 100%,rgba(168,0,119,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cb60b3', endColorstr='#a80077',GradientType=0 ); /* IE6-9 */; text-align:left; height:25px;">
	<div id="cssm1">
		<?display_children(0, 0, $_SESSION["hak_akses"]);?>
	</div>
</div>
<div id="content"></div>
</body>

<style>
.head-list {
/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#cb60b3+0,c146a1+0,a80077+100,db36a4+100,a80077+100 */
background: rgb(203,96,179); /* Old browsers */
background: -moz-linear-gradient(top, rgba(203,96,179,1) 0%, rgba(193,70,161,1) 0%, rgba(168,0,119,1) 100%, rgba(219,54,164,1) 100%, rgba(168,0,119,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, rgba(203,96,179,1) 0%,rgba(193,70,161,1) 0%,rgba(168,0,119,1) 100%,rgba(219,54,164,1) 100%,rgba(168,0,119,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, rgba(203,96,179,1) 0%,rgba(193,70,161,1) 0%,rgba(168,0,119,1) 100%,rgba(219,54,164,1) 100%,rgba(168,0,119,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cb60b3', endColorstr='#a80077',GradientType=0 ); /* IE6-9 */
}
</style>
</html>

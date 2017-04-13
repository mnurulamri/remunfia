<?php
//session_start();
include("conn.php");
include("menu.php");

$username = $_SESSION["username"];

if (isset($_GET["vnamapengajar"])){
	$vnamapengajar = $_GET["vnamapengajar"];
} else {
	$vnamapengajar = "";
}

$kd_organisasi = $_SESSION["kd_organisasi"];

if ($username == "admin"){
$query = "select * from hs_bimbingan";
} else {
$query = "select * from hs_bimbingan where kd_organisasi = '$kd_organisasi'";
}

$data = mysql_query($query) or die (mysql_error());
while ($row = mysql_fetch_array($data)){
	$ketua = $row["ketua"];
	$penguji = $row["penguji"];
	$pembimbing = $row["pembimbing"];
	$sekretaris = $row["sekretaris"];
	$ketua_proposal = $row["ketua_proposal"];
	$penguji_proposal = $row["penguji_proposal"];
	$pembimbing_proposal = $row["pembimbing_proposal"];
	$sekretaris_proposal = $row["sekretaris_proposal"];
}
?>
<html>


<!-----------------------------------------------------------------
					Tampilan bimbingan detail
------------------------------------------------------------------>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<title>Honor Pembimbingan <? echo $_SESSION["programstudi"];?></title>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="../remun/grid/gt_grid_height.css" />
<link rel="stylesheet" type="text/css" href="../remun/grid/skin/vista/skinstyle.css" />
<script type="text/javascript" src="../remun/grid/gt_msg_en.js"></script>
<script type="text/javascript" src="../remun/grid/gt_grid_all.js"></script>
<script type="text/javascript" src="../remun/grid/flashchart/fusioncharts/FusionCharts.js"></script>
<script type="text/javascript" src="../remun/grid/calendar/calendar.js"></script>
<script type="text/javascript" src="../remun/grid/calendar/calendar-setup.js"></script>
<script src="../remun/highlight/jssc3.js" type="text/javascript"></script>
<link href="../remun/highlight/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var grid_demo_id = "myGrid1";
var dsOption= {
	fields :[ //name pada fields bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
		{name: 'kd_organisasi'},
		{name: 'programstudi'},
		{name: 'ketua_proposal'},
		{name: 'penguji_proposal'},
		{name: 'pembimbing_proposal'},
		{name: 'sekretaris_proposal'},
		{name: 'ketua'},
		{name: 'penguji'},
		{name: 'pembimbing'},
		{name: 'sekretaris'},
	],
	recordType : 'object'
}

function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {
  var x = Math.round(num * Math.pow(10,dec));
  if (x >= 0) n1=n2='';
  var y = (''+Math.abs(x)).split('');
  var z = y.length - dec;
  if (z<0) z--;
  for(var i = z; i < 0; i++) y.unshift('0');
  if (z<0) z = 1;
  y.splice(z, 0, pnt);
  if(y[0] == pnt) y.unshift('0');
  while (z > 3) {
    z-=3; y.splice(z,0,thou);
  }
  var r = curr1+n1+y.join('')+n2+curr2;
  return r;
}

var colsOption = [ //id pada colsOption bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
	//{id: 'chk' ,isCheckColumn : true, editable:false },
	{id: 'kd_organisasi', header: "Kode Organisasi", width :100},
	{id: 'programstudi', header: "Program Studi", width :300},
	{id: 'ketua_proposal', header: "Ketua Sidang Proposal", width :150,  editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'penguji_proposal', header: "Penguji Sidang Proposal", width :150, editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'pembimbing_proposal', header: "Pembimbing Proposal", width :150, editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'sekretaris_proposal', header: "Sekretaris Sidang Proposal", editor:{type:"text"}, width :150, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'ketua', header: "Ketua Sidang ", width :150, editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'penguji', header: "Penguji", width :150, editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'pembimbing', header: "Pembimbing", width :150, editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
	{id: 'sekretaris', header: "Sekretaris", width :150, editor:{type:"text"}, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}},
];

var gridOption={
	id : grid_demo_id,
	loadURL : 'controller_hs_bimbingan.php',
	saveURL : 'controller_hs_bimbingan.php',
	exportURL : '',	
	width: "100%",  //"100%", // 700,
	height: 300,  //"100%", // 330,
	container : 'gridbox',
	replaceContainer : true,
	encoding : 'UTF-8', // Sigma.$encoding(),
	dataset : dsOption ,
	columns : colsOption ,
	clickStartEdit : true ,
	showIndexColumn : false,
	pageSize:10000,
	reloadAfterSave: true,
	submitUpdatedFields: true,
	toolbarContent : 'reload | save'
};

var mygrid=new Sigma.Grid( gridOption );
Sigma.Util.onLoad(function(){mygrid.render()});

//////////////////////////////////////////////////////////

</script>
<style>
#teks {font:bold 11px verdana;text-align:left; color:yellow;}
</style>
<br><br>
<body style="margin:0; padding:0; background:#336666;">
<div id="page-container">
	<div id="header"></div>
	<div style="margin:15px;display:!none;"></div>				
	<div id="content">
		<div id="bigbox" style="margin:15px;display:!none;">
			<div id="gridbox"></div>
		</div>
	</div>
</div>
</body>
</html>
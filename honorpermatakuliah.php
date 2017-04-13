<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include("menu.php") ?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Absensi Pengajar <? echo $_SESSION["programstudi"];?></title>
<link rel="stylesheet" type="text/css" href="../grid/gt_grid.css" />
<link rel="stylesheet" type="text/css" href="../grid/skin/vista/skinstyle.css" />
<script type="text/javascript" src="../grid/gt_msg_en.js"></script>
<script type="text/javascript" src="../grid/gt_grid_all.js"></script>
<script type="text/javascript" src="../grid/flashchart/fusioncharts/FusionCharts.js"></script>
<script type="text/javascript" src="../grid/calendar/calendar.js"></script>
<script type="text/javascript" src="../grid/calendar/calendar-setup.js"></script>
<script src="highlight/jssc3.js" type="text/javascript"></script>
<link href="highlight/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var grid_demo_id = "myGrid1";
var dsOption= {
	fields :[ //name pada fields bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
		{name: 'Program'},
		{name: 'ProgramStudi'},
		{name: 'NamaMataKuliah'},
		{name: 'NamaKelas'},
		{name: 'NamaPengajar'},
		{name: 'HadirAktual'},
		{name: 'KehadiranSeharusnya'},
		{name: 'HonorXuSkemaInti'},
		{name: 'HonorXfSkemaInti'},
		{name: 'HonorXfSkemaLain'},
		{name: 'HonorXfLintasFak'},
		{name: 'TotalHonor'},
		{name: 'IkutHitung'}
	],
	recordType : 'object'
}

var colsOption = [ //id pada colsOption bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
{id: 'Program' , header: "Program" , width :80, frozen:true},
{id: 'ProgramStudi' , header: "Program Studi" , width :166, frozen:true},
{id: 'NamaMataKuliah' , header: "Nama Mata Kuliah" , width :280, frozen:true},
{id: 'NamaKelas' , header: "Nama Kelas" , width :166, frozen:true},
{id: 'NamaPengajar' , header: "Nama Pengajar" , width :200, frozen:true},
{id: 'HadirAktual' , header: "Hadir Aktual" , align: "center", width :80},
{id: 'KehadiranSeharusnya' , header: "Kehadiran Seharusnya" , align: "center", width :80},
{id: 'HonorXuSkemaInti' , header: "Honor Xu" , width :90,align: "right", renderer :function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","");}},
{id: 'HonorXfSkemaInti' , header: "Honor Xf Skema Inti" , width :90,align: "right", renderer :function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","");}},
{id: 'HonorXfSkemaLain' , header: "Honor Xf Skema Lain" , width :90,align: "right", renderer :function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","");}},
{id: 'HonorXfLintasFak' , header: "Honor Xf Lintas Fak." , width :90,align: "right", renderer :function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","");}},
{id: 'IkutHitung' , header: "IkutHitung" , align: "center", width :50}
];

var gridOption={
	id : grid_demo_id,
	loadURL : 'Controller.php',
	saveURL : 'Controller.php',
	exportURL : 'export_excel.php',	
	width: "100%",  //"100%", // 700,
	height: 380,  //"100%", // 330,
	container : 'gridbox',
	replaceContainer : true,
	encoding : 'UTF-8', // Sigma.$encoding(),
	dataset : dsOption ,
	columns : colsOption ,
	clickStartEdit : true ,
	showIndexColumn : true,
	pageSize:10000,
	reloadAfterSave: true,
	submitUpdatedFields: true,
	toolbarContent : 'reload | save | xls | print'
};

var mygrid=new Sigma.Grid( gridOption );
Sigma.Util.onLoad(function(){mygrid.render()});

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
//////////////////////////////////////////////////////////

function changeBgImage (image, id) {
	var element = document.getElementById(id);
	element.style.backgroundImage = "url("+image+")";
}

function logout(){	
	window.location = 'index.php';
}
</script>

</head>
<body bgcolor="336666">

<table width="56px" align="right">
<tr><td><a href='index.php'><img src="logout1.png" onmouseover="this.src='logout2.png';" onmouseout="this.src='logout1.png';" height=40 width=40/></a></td></tr>
</body>
</table>
<table width="100%">

</table>
<div id="page-container">
<div id="header">
</div>
<br><br>
<strong><font color="yellow" size="4px">&nbsp;&nbsp;&nbsp;Filter Berdasarkan Nama Pengajar </font><font color="yellow">(case sensitive)</font>  : </strong><input type="text" id="f_value1" value="" onKeyUp="doFilter()"/>
<div id="content">
<div id="bigbox" style="margin:15px;display:!none;">
<div id="gridbox" style="border:0px solid #cccccc;background-color:#f3f3f3;padding:5px;height:200px;width:700px;" ></div>
</div>
</div>
</div>

<!-- test filter-->
<script type="text/javascript" >
function doFilter() {
	var filterInfo=[
	{
		fieldName : "NamaPengajar",
		logic : "like",
		value : Sigma.Util.getValue("f_value1")
	}
	]
	var grid=Sigma.$grid("myGrid1");
	var rowNOs=grid.applyFilter(filterInfo); 
}
</script>
</body>
</html>


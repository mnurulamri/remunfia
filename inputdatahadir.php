<?
if(!session_id()) session_start();
if(empty($_SESSION['username'])|| !isset($_SESSION['username']))	header("Location:index.php");

if($_SESSION["semester"] == "gasal"){
	$bulan = array("HadirSeptember","HadirOktober","HadirNovember","HadirDesember","HadirJanuari");
	$header = array("September","Oktober","November","Desember","Januari");
} else {
	$bulan = array("HadirFebruari","HadirMaret","HadirApril","HadirMei","HadirJuni","HadirJuli","HadirAgustus");
	$header = array("Februari","Maret","April","Mei","Juni","Juli","Agustus");
}

include("bulan.php");

//Closing data hadir
include("conn.php");
$sql = "SELECT bulan, lock_data FROM data_hadir_lock WHERE tahun_akad = 2016 AND semester = 2";
$result = mysql_query($sql) or die();

while($rows = mysql_fetch_object($result)){
	$data[$rows->bulan] = $rows->lock_data;
}

//menentukan bulan apa yang akan di closing
if(isset($data['09'])){$txtSep = $data['09'] == 1 ? null : 'text';}
if(isset($data['10'])){$txtOkt = $data['10'] == 1 ? null : 'text';}
if(isset($data['11'])){$txtNov = $data['11'] == 1 ? null : 'text';}
if(isset($data['12'])){$txtDes = $data['12'] == 1 ? null : 'text';}
if(isset($data['01'])){$txtJan = $data['01'] == 1 ? null : 'text';}
if(isset($data['02'])){$txtFeb = $data['02'] == 1 ? null : 'text';}
if(isset($data['03'])){$txtMar = $data['03'] == 1 ? null : 'text';}
if(isset($data['04'])){$txtApr = $data['04'] == 1 ? null : 'text';}
if(isset($data['05'])){$txtMei = $data['05'] == 1 ? null : 'text';}
if(isset($data['06'])){$txtJun = $data['06'] == 1 ? null : 'text';}
if(isset($data['07'])){$txtJul = $data['07'] == 1 ? null : 'text';}
if(isset($data['08'])){$txtAgt = $data['08'] == 1 ? null : 'text';}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Absensi Pengajar <? echo $_SESSION["programstudi"];?></title>
<link rel="stylesheet" type="text/css" href="/grid/gt_grid_height.css" />
<link rel="stylesheet" type="text/css" href="/grid/skin/mac/skinstyle.css" />
<script type="text/javascript" src="/grid/gt_msg_en.js"></script>
<script type="text/javascript" src="/grid/gt_grid_all.js"></script>
<script type="text/javascript" src="/grid/flashchart/fusioncharts/FusionCharts.js"></script>
<script type="text/javascript" src="/grid/calendar/calendar.js"></script>
<script type="text/javascript" src="/grid/calendar/calendar-setup.js"></script>
<script src="/highlight/jssc3.js" type="text/javascript"></script>
<link href="/highlight/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/search/autocomplete.css" type="text/css" media="screen">
<script src="/search/jquery.js" type="text/javascript"></script>
<script src="/search/dimensions.js" type="text/javascript"></script>
<script src="/search/searchPengajar.js" type="text/javascript"></script>
<script src="/search/searchMataKuliah.js" type="text/javascript"></script>
<script type="text/javascript" >

//==============================================================================================================
<?if($_SESSION["semester"] == "gasal"){?>
var grid_demo_id = "myGrid1";
var dsOption= {
	fields :[ //name pada fields bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
		{name: 'Hari'},
		{name: 'Jam'},
		{name: 'Id'},
		{name: 'Program'},
		{name: 'ProgramStudi'},
		{name: 'NamaMataKuliah'},
		{name: 'NamaKelas'},
		{name: 'NamaPengajar'},
		{name: '<?echo $bulan[0]?>', type:'int'},		
		{name: '<?echo $bulan[1]?>', type:'int'},		
		{name: '<?echo $bulan[2]?>', type:'int'},		
		{name: '<?echo $bulan[3]?>', type:'int'},
		{name: '<?echo $bulan[4]?>', type:'int'},
		{name: 'Total', type: 'int', initValue: function(record){
										hadir0 = parseInt(record['<?echo $bulan[0]?>']);
										hadir1 = parseInt(record['<?echo $bulan[1]?>']);
										hadir2 = parseInt(record['<?echo $bulan[2]?>']);
										hadir3 = parseInt(record['<?echo $bulan[3]?>']);
										hadir4 = parseInt(record['<?echo $bulan[4]?>']);
										totalhadir = hadir0 + hadir1 + hadir2 + hadir3 + hadir4;										
										return totalhadir;
							     }
		},
		{name: 'KehadiranSeharusnya'}
	],
	recordType : 'object'
}
<?} else {?>
var grid_demo_id = "myGrid1";
var dsOption= {
	fields :[ //name pada fields bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
		{name: 'Hari'},
		{name: 'Jam'},
		{name: 'Id'},
		{name: 'Program'},
		{name: 'ProgramStudi'},
		{name: 'NamaMataKuliah'},
		{name: 'NamaKelas'},
		{name: 'NamaPengajar'},
		{name: '<?echo $bulan[0]?>', type:'int'},		
		{name: '<?echo $bulan[1]?>', type:'int'},		
		{name: '<?echo $bulan[2]?>', type:'int'},		
		{name: '<?echo $bulan[3]?>', type:'int'},
		{name: '<?echo $bulan[4]?>', type:'int'},
		{name: '<?echo $bulan[5]?>', type:'int'},
		{name: '<?echo $bulan[6]?>', type:'int'},
		{name: 'Total', type: 'int', initValue: function(record){
										hadir0 = parseInt(record['<?echo $bulan[0]?>']);
										hadir1 = parseInt(record['<?echo $bulan[1]?>']);
										hadir2 = parseInt(record['<?echo $bulan[2]?>']);
										hadir3 = parseInt(record['<?echo $bulan[3]?>']);
										hadir4 = parseInt(record['<?echo $bulan[4]?>']);
										hadir5 = parseInt(record['<?echo $bulan[5]?>']);
										hadir6 = parseInt(record['<?echo $bulan[6]?>']);
										totalhadir = hadir0 + hadir1 + hadir2 + hadir3 + hadir4 + hadir5 + hadir6;										
										return totalhadir;
							     }
		},
		{name: 'KehadiranSeharusnya'}
	],
	recordType : 'object'
}
<?}?>

function tes(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var drop = "drop..";
		var color = "dark-gray";		
		if (value == 0){
			return "<span style='color:red;'><strong>" + drop + "</strong></span>";
		} else {
			return "<span style='color:" + color + ";'>" + no + "</span>";
		}		
}

function styleaktual(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "green";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}

function styleseptember(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#CC0000";		
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}

function styledesember(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#3300FF";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}

function stylenovember(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#3366FF";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}

function styleoktober(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "magenta";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}

function stylejuli(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#7D551A";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}	

function styleagustus(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#571B7E";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}		

function styletotal(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#105952";
		return "<span style='color:" + color + ";'><strong>" + no + "</strong></span>";
}

function stylewajibhadir(value ,record,columnObj,grid,colNo,rowNo){
		var no = record[columnObj.fieldIndex];
		var color = "#FF6600";
		return "<span style='color:" + color + "; text-align:center'><strong>" + no + "</strong></span>";
}

//===========================================  SEMESTER GASAL ===================================================
<?if($_SESSION["semester"] == "gasal"){?>
var colsOption = [ //id pada colsOption bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
{id: 'Hari' , header: "Hari" , width :90, frozen:false},
{id: 'Jam', header: "Jam" , width :80, frozen:false},
{id: 'Id', header: "ID" , width :50, hidden:false, frozen:false, renderer: tes},
{id: 'Program' , header: "Program" , width :45, frozen:false},
{id: 'ProgramStudi' , header: "Program Studi" , width :80, frozen:false},
{id: 'NamaMataKuliah' , header: "Nama Mata Kuliah" , width :180, frozen:false},
{id: 'NamaKelas' , header: "Nama Kelas" , width :150, frozen:false},
{id: 'NamaPengajar' , header: "Nama Pengajar" , width :150, frozen:false, editor: {type:""}},

<?if ($bulan_aktual == $bulan[0]){?>
{id: '<?echo $bulan[0]?>' , header: "<?echo $header[0]?>" , editor: {type:"<?=$txtSep?>"}, width :80, renderer: styleseptember},
<?} else {?>
{id: '<?echo $bulan[0]?>' , header: "<?echo $header[0]?>" , editor: {type:"<?=$txtSep?>"}, width :80, renderer: styleseptember},
<?}?>

<?if ($bulan_aktual == $bulan[1]){?>
{id: '<?echo $bulan[1]?>' , header: "<?echo $header[1]?>" , editor: {type:"<?=$txtOkt?>"}, width :80, renderer: styleoktober},
<?} else {?>
{id: '<?echo $bulan[1]?>' , header: "<?echo $header[1]?>" , editor: {type:"<?=$txtOkt?>"}, width :80, renderer: styleoktober},
<?}?>

<?if ($bulan_aktual == $bulan[2]){?>
{id: '<?echo $bulan[2]?>' , header: "<?echo $header[2]?>" , editor: {type:"<?=$txtNov?>"}, width :80, renderer:stylenovember},
<?} else {?>
{id: '<?echo $bulan[2]?>' , header: "<?echo $header[2]?>" , width :80, editor: {type:"<?=$txtDes?>"}, renderer:stylenovember},
<?}?>

<?if ($bulan_aktual == $bulan[3]){?>
{id: '<?echo $bulan[3]?>' , header: "<?echo $header[3]?>" , editor: {type:"<?=$txtDes?>"}, width :80, renderer:styledesember},
<?} else {?>
{id: '<?echo $bulan[3]?>' , header: "<?echo $header[3]?>" , width :80, editor: {type:"<?=$txtDes?>"}, renderer:styledesember},
<?}?>

<?if ($bulan_aktual == $bulan[4]){?>
{id: '<?echo $bulan[4]?>' , header: "<?echo $header[4]?>" , editor: {type:"<?=$txtJan?>"}, width :80, renderer:styleaktual},
<?} else {?>
{id: '<?echo $bulan[4]?>' , header: "<?echo $header[4]?>" , editor: {type:"<?=$txtJan?>"} , width :80, renderer:styleaktual},
<?}?>

{id: 'Total' , header: "Total Hadir" , width :80, renderer: styletotal},
{id: 'KehadiranSeharusnya' , header: "Wajib Hadir" , width :80, renderer: stylewajibhadir, editor: {type:""}}
];
//===========================================  SEMESTER GENAP ===================================================
<?} else {?>  //jika semester genap - ada tambahan untuk bulan Juli dan Agustus
var colsOption = [ //id pada colsOption bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
{id: 'Hari' , header: "Hari" , width :60, frozen:false},
{id: 'Jam', header: "Jam" , width :80, frozen:false},
{id: 'Id', header: "ID" , width :50, hidden:false, frozen:false, renderer: tes},
{id: 'Program' , header: "Program" , width :45, frozen:false},
{id: 'ProgramStudi' , header: "Program Studi" , width :80, frozen:false},
{id: 'NamaMataKuliah' , header: "Nama Mata Kuliah" , width :180, frozen:false},
{id: 'NamaKelas' , header: "Nama Kelas" , width :150, frozen:false},
{id: 'NamaPengajar' , header: "Nama Pengajar" , width :150, frozen:false, editor: {type:""}},

<?if ($bulan_aktual == $bulan[0]){?>
{id: '<?echo $bulan[0]?>' , header: "<?echo $header[0]?>" , editor: {type:"<?=$txtFeb?>"}, width :60, renderer: styleseptember},
<?} else {?>
{id: '<?echo $bulan[0]?>' , header: "<?echo $header[0]?>" ,  editor: {type:"<?=$txtFeb?>"}, width :60, renderer: styleseptember},
<?}?>

<?if ($bulan_aktual == $bulan[1]){?>
{id: '<?echo $bulan[1]?>' , header: "<?echo $header[1]?>" , editor: {type:"<?=$txtMar?>"}, width :60, renderer: styleoktober},
<?} else {?>
{id: '<?echo $bulan[1]?>' , header: "<?echo $header[1]?>" , editor: {type:"<?=$txtMar?>"}, width :60, renderer: styleoktober},
<?}?>

<?if ($bulan_aktual == $bulan[2]){?>
{id: '<?echo $bulan[2]?>' , header: "<?echo $header[2]?>" , editor: {type:"<?=$txtApr?>"}, width :60, renderer:stylenovember},
<?} else {?>
{id: '<?echo $bulan[2]?>' , header: "<?echo $header[2]?>" , width :60, editor: {type:"<?=$txtApr?>"}, renderer:stylenovember},
<?}?>

<?if ($bulan_aktual == $bulan[3]){?>
{id: '<?echo $bulan[3]?>' , header: "<?echo $header[3]?>" , editor: {type:"<?=$txtMei?>"}, width :60, renderer:styledesember},
<?} else {?>
{id: '<?echo $bulan[3]?>' , header: "<?echo $header[3]?>" , width :60, editor: {type:"<?=$txtMei?>"}, renderer:styledesember},
<?}?>

<?if ($bulan_aktual == $bulan[4]){?>
{id: '<?echo $bulan[4]?>' , header: "<?echo $header[4]?>" , editor: {type:"<?=$txtJun?>"}, width :60, renderer:styleaktual},
<?} else {?>
{id: '<?echo $bulan[4]?>' , header: "<?echo $header[4]?>" , editor: {type:"<?=$txtJun?>"}, width :60, renderer:styleaktual},
<?}?>

<?if ($bulan_aktual == $bulan[5]){?>
{id: '<?echo $bulan[5]?>' , header: "<?echo $header[5]?>" , editor: {type:"<?=$txtJul?>"}, width :60, renderer:stylejuli},
<?} else {?>
{id: '<?echo $bulan[5]?>' , header: "<?echo $header[5]?>" , editor: {type:"<?=$txtJul?>"}, width :60, renderer:stylejuli},
<?}?>

<?if ($bulan_aktual == $bulan[6]){?>
{id: '<?echo $bulan[6]?>' , header: "<?echo $header[6]?>" , editor: {type:"<?=$txtAgt?>"}, width :60, renderer:styleagustus},
<?} else {?>
{id: '<?echo $bulan[6]?>' , header: "<?echo $header[6]?>" , editor: {type:"<?=$txtAgt?>"}, width :60, renderer:styleagustus},
<?}?>	

{id: 'Total' , header: "Total Hadir" , width :70, renderer: styletotal},
{id: 'KehadiranSeharusnya' , header: "Wajib Hadir" , width :70, renderer: stylewajibhadir, editor: {type:""}}
];
<?}?>
var gridOption={
	id : grid_demo_id,
	loadURL : 'Controller.php',
	saveURL : 'Controller.php',
	exportURL : 'export_excel_data_hadir.php',	
	width: "100%",  //"100%", // 700,
	height: "400px",  //"100%", // 330,
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
	resizable : true,
	skin: 'mac',
	onComplete : function(){clock.start()},
	toolbarContent : 'reload | save '
};

var mygrid=new Sigma.Grid( gridOption );
Sigma.Util.onLoad(function(){mygrid.render()});

//////////////////////////////////////////////////////////

function logout(){	
	window.location = 'index.php';
}
</script>

</head>

<?php include("menu.php"); ?>

<body style="background:#eee">

	<table align="right" style="font: bold 12px arial; color: #444">
		<tr>
			<td><i>Data Siak: 2016-09-09 08:52</i></td>
		</tr>
		<tr><td><i>(data terakhir SIAK diupload ke SIPEG)</i></td></tr>
	</table>

	<table width="100%">
	</table>

	<div id="page-container">
		<div id="header">
		</div>
		<div align="center"><strong><font color="lightyellow" size="2px"><div style="color:#444">Jangan lupa menyimpan data!</div></font></strong></div>		
		<br>
		<table width="100%" >
			<tr>
				<td align="left">
					<strong><font color="#444" size="2px">   Filter Berdasarkan Nama Pengajar </font><font color="#444" size="2px"></font>  : </strong>
					<input type="text" id="searchPengajar" value="" onKeyUp="doFilterPengajar()" onfocus="Pengajar()" />
					<input type="button" value="..." id="clearPengajar" onclick="clearPengajar()"/>
				</td>
				<td align="left">
					<strong><font color="#444" size="2px">   Filter Berdasarkan Nama Mata Kuliah </font><font color="#444" size="2px"></font>  : </strong>
					<input type="text" id="searchMataKuliah" value="" onKeyUp="doFilterMataKuliah()" onfocus="MataKuliah()"/>
					<input type="button" value="..." id="clearMataKuliah" onclick="clearMataKuliah()"/>
				</td>
				<td align="left">
					<strong><font color="#444" size="2px">   Filter Berdasarkan Hari </font> : </strong>
					<select id="hari" onChange="doFilterHari()">
						<option value="">Pilih Hari...</option>
						<option value="Senin">Senin</option>
						<option value="Selasa">Selasa</option>
						<option value="Rabu">Rabu</option>
						<option value="Kamis">Kamis</option>
						<option value="Jumat">Jumat</option>
						<option value="Sabtu">Sabtu</option>					
					</select>
				</td>
			</tr>
		</table>
		
		<div id="content">
			<div id="bigbox" style="margin:15px;display:!none;">
				<div id="gridbox" style="border:0px solid #cccccc;background-color:#f3f3f3;padding:5px;height:200px;width:700px;" ></div>
			</div>
		</div>
	</div>

	<!-- test filter-->
	<script type="text/javascript" >

		function doFilterPengajar() {
			var filterInfo=[
			{
				fieldName : "NamaPengajar",
				logic : "like",
				value : Sigma.Util.getValue("searchPengajar")
			}
			]
			var grid=Sigma.$grid("myGrid1");
			var rowNOs=grid.applyFilter(filterInfo); 
		}

		function doFilterMataKuliah() {
			var filterInfo=[
			{
				fieldName : "NamaMataKuliah",
				logic : "like",
				value : Sigma.Util.getValue("searchMataKuliah")
			}
			]
			var grid=Sigma.$grid("myGrid1");
			var rowNOs=grid.applyFilter(filterInfo); 
		}

		function doFilterHari() {
			var filterInfo=[
			{
				fieldName : "Hari",
				logic : "like",
				value : Sigma.Util.getValue("hari")
			}
			]
			var grid=Sigma.$grid("myGrid1");
			var rowNOs=grid.applyFilter(filterInfo); 
		}

		function Pengajar(){
			setAutoCompletePengajar("searchPengajar", "resultPengajar", "../remun/search/searchPengajar.php?part=");
		};
		
		function MataKuliah(){
			setAutoCompleteMataKuliah("searchMataKuliah", "resultMataKuliah", "../remun/search/searchMataKuliah.php?part=");
		};
		
		function clearPengajar(){
			document.getElementById('searchPengajar').value='';
			document.getElementById('searchPengajar').focus();
			doFilterPengajar();
		};
		
		function clearMataKuliah(){
			document.getElementById('searchMataKuliah').value='';
			document.getElementById('searchMataKuliah').focus();
			doFilterMataKuliah();
		};
		
	</script>
</body>
</html>
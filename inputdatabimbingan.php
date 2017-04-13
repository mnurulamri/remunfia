<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include("menu.php");
include("conn.php");

$username = $_SESSION["username"];

if (isset($_GET["nip"])){
	$nip = $_GET["nip"];	

} else {
	$nip = "";
	
}

if (isset($_GET["vnamapengajar"])){
	$vnamapengajar = $_GET["vnamapengajar"];
} else {
	$vnamapengajar = "";
}

$kd_organisasi = $_SESSION["kd_organisasi"];

if ($username == "admin" or $username == "remunerasifisipui"){
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
<head>

<script>
	var cur = 0;
	function displayDiv(idx) {
		if (cur==idx) return true;
		document.getElementById("div"+cur).style.display = "none";
		document.getElementById("div"+idx).style.display = "block";
		cur = idx;
		return true;
	}
		
	window.onload = function() {
		return displayDiv(document.form.semester.selectedIndex);
	}
	
		function enter(str, e){
		var keycode;
		if (window.event) keycode = window.event.keyCode;
		else if (e) keycode = e.which;
		else return true;

		if (keycode == 13) {
		   showNamaPengajar(str); //panggil fungsi showNamaPengajar
		   return false;
		}
		else
		   return true;
	}

	function showNamaPengajar(str){
		if (str=="") {
		  document.getElementById("txtHint").innerHTML="";
		  return;
		 }
		if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		}
		else {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)	{
				document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			}
		 }
	xmlhttp.open("GET","getnamapengajar_bimbingan.php?namapengajar="+str,true);
	xmlhttp.send();
	}
	
</script>

<!-----------------------------------------------------------------
					Tampilan bimbingan detail
------------------------------------------------------------------>


<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>Tugas Bimbingan <? echo $_SESSION["programstudi"];?></title>
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
		{name: 'id'},
		{name: 'nm_bimbingan', initValue: function(record){
															if (record['nm_bimbingan']==1 || record['nm_bimbingan']=="Ketua Sidang Proposal"){
																tugas = 1;																
															} else if (record['nm_bimbingan']==2 || record['nm_bimbingan']=="Penguji Sidang Proposal"){
																tugas = 2;																
															} else if (record['nm_bimbingan']==3 || record['nm_bimbingan']=="Pembimbing Proposal"){
																tugas = 3;																
															} else if (record['nm_bimbingan']==4 || record['nm_bimbingan']=="Sekretaris Sidang Proposal"){
																tugas = 4;	
															} else if (record['nm_bimbingan']==5 || record['nm_bimbingan']=="Ketua Sidang Skripsi/Tesis/Disertasi"){
																tugas = 5;
															} else if (record['nm_bimbingan']==6 || record['nm_bimbingan']=="Penguji Sidang Skripsi/Tesis/Disertasi"){
																tugas = 6;																
															} else if (record['nm_bimbingan']==7 || record['nm_bimbingan']=="Pembimbing Skripsi/Tesis/Disertasi"){
																tugas = 7;																
															} else if (record['nm_bimbingan']==8 || record['nm_bimbingan']=="Sekretaris Sidang Skripsi/Tesis/Disertasi"){
																tugas = 8;
															} else {
																tugas = 0;
															}
															return tugas;
														}},
		{name: 'jml_mhs'},
		{name: 'harga_satuan', type: 'int',mode:'number', initValue: function(record){
															if (record['nm_bimbingan']==1 || record['nm_bimbingan']=="Ketua Sidang Proposal"){
																hs = <? echo $ketua_proposal?>;																
															} else if (record['nm_bimbingan']==2 || record['nm_bimbingan']=="Penguji Sidang Proposal"){
																hs = <? echo $penguji_proposal?>;																
															} else if (record['nm_bimbingan']==3 || record['nm_bimbingan']=="Pembimbing Proposal"){
																hs = <? echo $pembimbing_proposal?>;																
															} else if (record['nm_bimbingan']==4 || record['nm_bimbingan']=="Sekretaris Sidang Proposal"){
																hs = <? echo $sekretaris_proposal?>;
															} else if (record['nm_bimbingan']==5 || record['nm_bimbingan']=="Ketua Sidang Skripsi/Tesis/Disertasi"){
																hs = <? echo $ketua?>;
															} else if (record['nm_bimbingan']==6 || record['nm_bimbingan']=="Penguji Sidang Skripsi/Tesis/Disertasi"){
																hs = <? echo $penguji?>;																
															} else if (record['nm_bimbingan']==7 || record['nm_bimbingan']=="Pembimbing Skripsi/Tesis/Disertasi"){
																hs = <? echo $pembimbing?>;																
															} else if (record['nm_bimbingan']==8 || record['nm_bimbingan']=="Sekretaris Sidang Skripsi/Tesis/Disertasi"){
																hs = <? echo $sekretaris?>;
															} else {
																hs = 0;
															}
															return hs;
														}},
		{name: 'honor', type: 'int', initValue: function(record){
										jml_mhs = parseInt(record['jml_mhs']);
										harga_satuan = parseInt(record['harga_satuan']);
										honor = jml_mhs * harga_satuan;
										return honor;
							     }}
	],
	recordType : 'object'
}

function totalhonor(value ,record,columnObj,grid,colNo,rowNo){
		return "<span style='color:blue; text-align:right;'</span>";
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


function vharga_satuan(value, record, columnObj, grid, colNo, rowNo){	
	if (record['nm_bimbingan']=="Ketua Sidang Proposal" || record['nm_bimbingan']==1){
		hs = <? echo $ketua_proposal?>;
	} else if (record['nm_bimbingan']=="Penguji Sidang Proposal" || record['nm_bimbingan']==2){
		hs = <? echo $penguji_proposal?>;
	} else if (record['nm_bimbingan']=="Pembimbing Proposal" || record['nm_bimbingan']==3){
		hs = <? echo $pembimbing_proposal?>;
	} else if (record['nm_bimbingan']=="Sekretaris Sidang Proposal" || record['nm_bimbingan']==4){
		hs = <? echo $sekretaris_proposal?>;
	} else if (record['nm_bimbingan']=="Ketua Sidang Skripsi/Tesis/Disertasi" || record['nm_bimbingan']==5){
		hs = <? echo $ketua?>;
	} else if (record['nm_bimbingan']=="Penguji Sidang Skripsi/Tesis/Disertasi" || record['nm_bimbingan']==6){
		hs = <? echo $penguji?>;
	} else if (record['nm_bimbingan']=="Pembimbing Skripsi/Tesis/Disertasi" || record['nm_bimbingan']==7){
		hs = <? echo $pembimbing?>;
	} else if (record['nm_bimbingan']=="Sekretaris Sidang Skripsi/Tesis/Disertasi" || record['nm_bimbingan']==8){
		hs = <? echo $sekretaris?>;
	} else {
		hs = 0;
	}
	return hs;
}

function nm_bimbingan(value ,record,columnObj,grid,colNo,rowNo){
		 var options = {"0": "---Pilih Tugas---",
						"1": "Ketua Sidang Proposal",
						"2": "Penguji Sidang Proposal",
						"3": "Pembimbing Proposal",
						"4": "Sekretaris Sidang Proposal",
						"5": "Ketua Sidang Skripsi/Tesis/Disertasi",
						"6": "Penguji Sidang Skripsi/Tesis/Disertasi",
						"7": "Pembimbing Skripsi/Tesis/Disertasi",
						"8": "Sekretaris Sidang Skripsi/Tesis/Disertasi"
		};
		var ret = options[value];
		if(ret==null){
			ret = value;
		}
		return ret;
}

var colsOption = [ //id pada colsOption bersifat case sensitive, jadi sesuaikan dengan nama atribut dari table
	//{id: 'chk' ,isCheckColumn : true, editable:false },
	{id: 'id', header: "ID", width :150},
	{id: 'nm_bimbingan', header: "Nama Bimbingan", width :200, editor : { type :"select" ,options : {
		"0": "---Pilih Tugas---",
		"1": "Ketua Sidang Proposal",
		"2": "Penguji Sidang Proposal",
		"3": "Pembimbing Proposal",
		"4": "Sekretaris Sidang Proposal",
		"5": "Ketua Sidang Skripsi/Tesis/Disertasi",
		"6": "Penguji Sidang Skripsi/Tesis/Disertasi",
		"7": "Pembimbing Skripsi/Tesis/Disertasi",
		"8": "Sekretaris Sidang Skripsi/Tesis/Disertasi"
		}, defaultText : "" }, renderer:nm_bimbingan },
	{id: 'jml_mhs', header: "Jumlah Mahasiswa", width :150, editor:{type:"text"}},
	{id: 'harga_satuan', header: "Harga Satuan", width :150, renderer:vharga_satuan, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","");}},
	{id: 'honor', header: "Jumlah Honor", width :150, renderer: function(value, record, columnObj, grid, colNo, rowNo) { return formatNumber(value,0,",","","","","","")}}
];

var gridOption={
	id : grid_demo_id,
	loadURL : 'controller_bimbingan.php',
	saveURL : 'controller_bimbingan.php',
	exportURL : 'export_excel_data_hadir.php',	
	width: 850,  //"100%", // 700,
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
	<?if ($username == "admin" or $username == "remunerasifisipui"){?>
		toolbarContent : 'reload '
	<?} else {?>
		toolbarContent : 'reload | add | del | save '
	<?}?>
};

var mygrid=new Sigma.Grid( gridOption );
Sigma.Util.onLoad(function(){mygrid.render()});

//////////////////////////////////////////////////////////

</script>
<style>
	#teks {font:bold 11px verdana;text-align:left; color:yellow;}
</style>
</head>

<body style="margin:0; padding:0; background:#336666;">

<div style="margin-top:50px; text-align:left; padding-left:20px; text-align:center; ">
	<form name="caripengajar">
		<table>
			<tr>
				<td id="teks">Nama Pengajar</td>
				<td id="teks">&nbsp:&nbsp;&nbsp;</td>
				<td><input id="blank" style="font:bold 11px verdana;text-align:left;" type="text" name="vnamapengajar" onkeypress="return enter(this.value, event)" value="<?php echo $vnamapengajar ?>"/></td>
				<td><input type="button" value="clear" onclick="document.getElementById('blank').value = ''; document.getElementById('blank_nip').value = ''; document.getElementById('blank').focus(); <? $_SESSION['nip'] = ''; $_SESSION['totalhonor'] = 0;?> window.location='inputdatabimbingan.php'"/></td>
			</tr>
			<tr>
				<td id="teks">NIP</td>
				<td id="teks">&nbsp:&nbsp;&nbsp;</td>
				<td><input id="blank_nip" style="font:bold 11px verdana;text-align:left;" type="text" name="nip" value="<?php echo $nip ?>"/></td>
				<td></td>
			</tr>
		</table>
	</form>
	<div id="txtHint"></div> <!-- tempat untuk tampilan hasil pencarian nama pengajar -->
</div>


<?php
$_SESSION["nip"] = $nip;
?>

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
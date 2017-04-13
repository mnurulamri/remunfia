<?php
include("conn.php");
#include("menu.php");

if(!session_id()) session_start();

$kd_organisasi = $_SESSION["kd_organisasi"];
$username = $_SESSION["username"];
//$tahun = $_POST["tahun"];
$vbulan = "Mei";


switch($vbulan)
{
	case "Januari":
		$bulan = "01";
		break;
	case "Februari":
		$bulan = "02";
		break;
	case "Maret":
		$bulan = "03";
		break;
	case "April":
		$bulan = "04";
		break;
	case "Mei":
		$bulan = "05";
		break;
	case "Juni":
		$bulan = "06";
		break;
	case "Juli":
		$bulan = "07";
		break;
	case "Agustus":
		$bulan = "08";
		break;
	case "September":
		$bulan = "09";
		break;
	case "Oktober":
		$bulan = "10";
		break;
	case "November":
		$bulan = "11";
		break;
	case "Desember":
		$bulan = "12";
		break;
}

$sql = "SELECT distinct kodeorganisasi, programstudi, program, sum(hadiraktual) as hadiaktual
		FROM kalban
		WHERE tahun=2014 and bulan='05'
		GROUP BY kodeorganisasi
		ORDER BY substr(kodeorganisasi,4,2)";

$result = mysql_query($sql) or die (mysql_error());

$rows = mysql_num_rows($result);

if($rows > 0){

	$data = "";

	$data = array();

	while ($row = mysql_fetch_object($result)){

		$data[$row->program][] = $row;

	}

	echo "
	<body style='background:#336666'>
	<div style='height:10%; background:yellow'>&nbsp;</div>
	<div style='height:3%; background:#555555'>&nbsp;</div>
	<div style='text-align:center'>
	";

	$grand_total_honor = 0;
	
	foreach ($data as $index => $baris){	
		
		echo "
		
		<table class='gridtable' align='center'>
		
		<tr><th colspan='4'>{$index}</th></tr>
		
		<tr>
		
			<th>Kode Organisasi</th>
			
			<th>Program Studi</th>
			
			<th>Jenjang</th>
			
			<th>Total Hadir</th>
			
		<tr>
		
		";
		
		$total_honor = 0;
		
		foreach ($baris as $kolom){	
			
			echo "
			
			<tr onMouseOver=\"this.style.backgroundColor='#FFCCFF'\" onMouseOut=\"this.style.backgroundColor='#ffffff'\">
			
				<td align='left'>{$kolom->kodeorganisasi}</td>
				
				<td>{$kolom->programstudi}</td>
				
				<td align='right'>".$kolom->program."</td>
				
				<td align='right'>".$kolom->hadiraktual."</td>
				
			</tr>
			
			";	
			
			//$total_honor += $kolom->honor;
			
			//$grand_total_honor += $kolom->honor;

		}

		echo "
		<!--<tr><td colspan='3' style='background:#555555; border-left:#336666; border-bottom:#336666'></td><td align='right'><strong>".number_format($total_honor)."</strong></td></tr>-->
		</table>		
		";
		
	}
	echo "
	<div style='height:3%; background:#555555'>&nbsp;</div>
	<div style='height:10%; padding-top:1%; background:yellow; font-family: verdana,arial,sans-serif; font-size:11px; color:#555555'><strong> Grand Total Honor Bimbingan : ".number_format($grand_total_honor)."</strong></div>";
} else {
	echo "<div style='font-family: verdana,arial,sans-serif; font-size:11px; color:white;'><strong>Tidak Ada Data!</strong></div>";
}
?>
</div>
<html>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
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
	border-width: 1px;
	padding: 8px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>

<!-- Table goes in the document BODY -->

</body>
</html>
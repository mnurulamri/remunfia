<?php
if(!session_id()) session_start();
// Connect database.
include("conn.php");
//set variabel
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];

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

//set query
$sql = "select program, prodi, a.nip as nip, nama_pengajar, jenis_bimbingan as keterangan, honor
		from bimbingan a, organisasi b, master_pengajar c
		where kd_organisasi = kodeorganisasi and  
				a.nip = c.nip and 
				a.tahun = $tahun and 
				a.bulan = '$bulan'";


// Get data records from table.
$result = mysql_query($sql);

// Functions for export to excel.
function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	return;
}

function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
	return;
}

function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
	return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
	return;
	}

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=bimbingan_insentif.xls ");
header("Content-Transfer-Encoding: binary ");
xlsBOF();

/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/
xlsWriteLabel(0,0,"jenjang_$bulan-$tahun");
xlsWriteLabel(0,1,"prodi_$bulan-$tahun");
xlsWriteLabel(0,2,"nip_$bulan-$tahun");
xlsWriteLabel(0,3,"nama_pengajar_$bulan-$tahun");
xlsWriteLabel(0,4,"keterangan_$bulan-$tahun");
xlsWriteLabel(0,5,"honor_$bulan-$tahun");

$xlsRow = 1;
// Put data records from mysql by while loop.
while($row=mysql_fetch_array($result)){	
	xlsWriteLabel($xlsRow,0,$row['program']);
	xlsWriteLabel($xlsRow,1,$row['prodi']);
	xlsWriteLabel($xlsRow,2,$row['nip']);
	xlsWriteLabel($xlsRow,3,$row['nama_pengajar']);
	xlsWriteLabel($xlsRow,4,$row['keterangan']);
	xlsWriteNumber($xlsRow,5,$row['honor']);
	$xlsRow++;
}
xlsEOF();
exit();
?>

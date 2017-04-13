<?php
if(!session_id()) session_start();
// Connect database.
mysql_connect("localhost","remun","usbw");
mysql_select_db("remun");
//$sql = $_SESSION["sql"];

$sql_1 = $_SESSION["sql_1"];
$sql_2 = $_SESSION["sql_2"];
$sql_3 = "and periode = 'November'";
$sql_4 = $_SESSION["sql_4"];
$sql = $sql_1.$sql_2.$sql_3.$sql_4;

$programstudi = $_SESSION["programstudi"];

// Get data records from table.
$result=mysql_query($sql);

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
header("Content-Disposition: attachment;filename=absensi_pengajar_november_2011.xls ");
header("Content-Transfer-Encoding: binary ");
xlsBOF();
/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/
xlsWriteLabel(0,0,"Universitas Indonesia");
xlsWriteLabel(1,0,"Fakultas Ilmu Sosial dan Ilmu Politik");
xlsWriteLabel(2,0,"$programstudi");
xlsWriteLabel(3,0,"Absensi Pengajar Periode November 2011");

// Make column labels. (at line 3)
xlsWriteLabel(5,0,"Jenjang");
xlsWriteLabel(5,1,"Nama Mata Kuliah");
xlsWriteLabel(5,2,"Nama Kelas");
xlsWriteLabel(5,3,"Nama Pengajar");
xlsWriteLabel(5,4,"Hadir Aktual");
xlsWriteLabel(5,5,"Kehadiran Seharusnya");
xlsWriteLabel(5,6,"Ikut Hitung");

$xlsRow = 6;
// Put data records from mysql by while loop.
while($row=mysql_fetch_array($result)){
	xlsWriteLabel($xlsRow,0,$row['Program']);
	xlsWriteLabel($xlsRow,1,$row['NamaMataKuliah']);
	xlsWriteLabel($xlsRow,2,$row['NamaKelas']);
	xlsWriteLabel($xlsRow,3,$row['NamaPengajar']);
	xlsWriteLabel($xlsRow,4,$row['HadirAktual']);
	xlsWriteLabel($xlsRow,5,$row['KehadiranSeharusnya']);
	xlsWriteLabel($xlsRow,6,$row['IkutHitung']);
	$xlsRow++;
}
xlsEOF();
exit();
?>

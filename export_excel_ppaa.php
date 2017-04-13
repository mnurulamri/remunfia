<?php
if(!session_id()) session_start();
// Connect database.
mysql_connect("localhost","remun","usbw");
mysql_select_db("remun");
//$sql = $_SESSION["sql"];

$sql = "select * from data where ((kodeorganisasi = '01.02.09.01' or kodeorganisasi = '02.02.09.01' or kodeorganisasi = '05.02.09.01' or kodeorganisasi = '08.03.09.01'
				or kodeorganisasi = '09.03.09.01' or kodeorganisasi = '10.03.09.01' or kodeorganisasi = '01.04.09.01' or kodeorganisasi = '02.05.09.01'
				or kodeorganisasi = '05.05.09.01' or kodeorganisasi = '01.06.09.01' or kodeorganisasi = '02.07.09.01' or kodeorganisasi = '01.08.09.01')
				or (kodemk = 'ISP20044' or kodemk = 'ISP20036' or kodemk = 'ISP20031' or kodemk = 'ISP20043' or kodemk = 'ISP20035' or kodemk = 'ISP22027') 
				and (left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI')) and flagtampil=1 and hari <> ''
		order by hari desc, jam, ruang";

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
header("Content-Disposition: attachment;filename=kalkulator_beban.xls ");
header("Content-Transfer-Encoding: binary ");
xlsBOF();
/*
Make a top line on your excel sheet at line 1 (starting at 0).
The first number is the row number and the second number is the column, both are start at '0'
*/
xlsWriteLabel(0,0,"UNIVERSITAS INDONESIA");
xlsWriteLabel(1,0,"FAKULTAS ILMU SOSIAL DAN ILMU POLITIK");
xlsWriteLabel(2,0,"");
xlsWriteLabel(3,0,"KEHADIRAN PENGAJAR PERIODE DESEMBER 2011");
// Make column labels. (at line 3)
xlsWriteLabel(5,0,"Hari");
xlsWriteLabel(5,1,"Jam");
xlsWriteLabel(5,2,"Program");
xlsWriteLabel(5,3,"ProgramStudi");
xlsWriteLabel(5,4,"NamaMataKuliah");
xlsWriteLabel(5,5,"NamaKelas");
xlsWriteLabel(5,6,"NamaPengajar");
xlsWriteLabel(5,7,"hadiroktober");
xlsWriteLabel(5,8,"HadirNovember");
xlsWriteLabel(5,9,"HadirDesember");

$xlsRow = 6;
// Put data records from mysql by while loop.
while($row=mysql_fetch_array($result)){
	xlsWriteLabel($xlsRow,0,$row['Hari']);
	xlsWriteLabel($xlsRow,1,$row['Jam']);
	xlsWriteLabel($xlsRow,2,$row['Program']);
	xlsWriteLabel($xlsRow,3,$row['ProgramStudi']);
	xlsWriteLabel($xlsRow,4,$row['NamaMataKuliah']);
	xlsWriteLabel($xlsRow,5,$row['NamaKelas']);
	xlsWriteLabel($xlsRow,6,$row['NamaPengajar']);
	xlsWriteLabel($xlsRow,7,$row['hadiroktober']);
	xlsWriteLabel($xlsRow,8,$row['HadirNovember']);
	xlsWriteLabel($xlsRow,9,$row['HadirDesember']);
	$xlsRow++;
}
xlsEOF();
exit();
?>

<?php
if(!session_id()) session_start();
// Connect database.
mysql_connect("localhost","remun","usbw");
mysql_select_db("remun");
$sql = $_SESSION["sql"];
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
xlsWriteLabel(3,0,"KALKULATOR BEBAN PERIODE OKTOBER 2011");
// Make column labels. (at line 3)
xlsWriteLabel(5,0,"No");
xlsWriteLabel(5,1,"Id");
xlsWriteLabel(5,2,"Nip");
xlsWriteLabel(5,3,"NamaPengajar");
xlsWriteLabel(5,4,"IndukFakultas");
xlsWriteLabel(5,5,"JabatanFungsional");
xlsWriteLabel(5,6,"Skema");
xlsWriteLabel(5,7,"BobotKontribusi");
xlsWriteLabel(5,8,"SKSEkivalen");
xlsWriteLabel(5,9,"TotSKSsiak");
xlsWriteLabel(5,10,"TotSKSOK");
xlsWriteLabel(5,11,"UnitFakultas");
xlsWriteLabel(5,12,"KodeOrganisasi");
xlsWriteLabel(5,13,"ProgramStudi");
xlsWriteLabel(5,14,"Jenjang");
xlsWriteLabel(5,15,"Program");
xlsWriteLabel(5,16,"KategoriKoefisien");
xlsWriteLabel(5,17,"NoSK");
xlsWriteLabel(5,18,"KodeMK");
xlsWriteLabel(5,19,"KodePDPT");
xlsWriteLabel(5,20,"NamaMataKuliah");
xlsWriteLabel(5,21,"SKS");
xlsWriteLabel(5,22,"JenisMataKuliah");
xlsWriteLabel(5,23,"UntukSms");
xlsWriteLabel(5,24,"Ditawarkan");
xlsWriteLabel(5,25,"KodeKelas");
xlsWriteLabel(5,26,"NamaKelas");
xlsWriteLabel(5,27,"JenisKelas");
xlsWriteLabel(5,28,"NipPJkelas");
xlsWriteLabel(5,29,"PengantarBhsAsing");
xlsWriteLabel(5,30,"HadirAktual");
xlsWriteLabel(5,31,"KehadiranSeharusnya");
xlsWriteLabel(5,32,"SatuanKehadiran");
xlsWriteLabel(5,33,"KehadiranAktualAsing");
xlsWriteLabel(5,34,"HadirAsing");
xlsWriteLabel(5,35,"SatuanHadirAsing");
xlsWriteLabel(5,36,"LintasFak");
xlsWriteLabel(5,37,"IkutHitung");
xlsWriteLabel(5,38,"KodePasca");
xlsWriteLabel(5,39,"SiakIdentifier");
xlsWriteLabel(5,40,"Hari");
xlsWriteLabel(5,41,"Jam");
xlsWriteLabel(5,42,"Ruang");
xlsWriteLabel(5,43,"flaghari");
$xlsRow = 6;
// Put data records from mysql by while loop.
while($row=mysql_fetch_array($result)){
	xlsWriteLabel($xlsRow,0,$row['No']);
	xlsWriteLabel($xlsRow,1,$row['Id']);
	xlsWriteLabel($xlsRow,2,$row['Nip']);
	xlsWriteLabel($xlsRow,3,$row['NamaPengajar']);
	xlsWriteLabel($xlsRow,4,$row['IndukFakultas']);
	xlsWriteLabel($xlsRow,5,$row['JabatanFungsional']);
	xlsWriteLabel($xlsRow,6,$row['Skema']);
	xlsWriteLabel($xlsRow,7,$row['BobotKontribusi']);
	xlsWriteLabel($xlsRow,8,$row['SKSEkivalen']);
	xlsWriteLabel($xlsRow,9,$row['TotSKSsiak']);
	xlsWriteLabel($xlsRow,10,$row['TotSKSOK']);
	xlsWriteLabel($xlsRow,11,$row['UnitFakultas']);
	xlsWriteLabel($xlsRow,12,$row['KodeOrganisasi']);
	xlsWriteLabel($xlsRow,13,$row['ProgramStudi']);
	xlsWriteLabel($xlsRow,14,$row['Jenjang']);
	xlsWriteLabel($xlsRow,15,$row['Program']);
	xlsWriteLabel($xlsRow,16,$row['KategoriKoefisien']);
	xlsWriteLabel($xlsRow,17,$row['NoSK']);
	xlsWriteLabel($xlsRow,18,$row['KodeMK']);
	xlsWriteLabel($xlsRow,19,$row['KodePDPT']);
	xlsWriteLabel($xlsRow,20,$row['NamaMataKuliah']);
	xlsWriteLabel($xlsRow,21,$row['SKS']);
	xlsWriteLabel($xlsRow,22,$row['JenisMataKuliah']);
	xlsWriteLabel($xlsRow,23,$row['UntukSms']);
	xlsWriteLabel($xlsRow,24,$row['Ditawarkan']);
	xlsWriteLabel($xlsRow,25,$row['KodeKelas']);
	xlsWriteLabel($xlsRow,26,$row['NamaKelas']);
	xlsWriteLabel($xlsRow,27,$row['JenisKelas']);
	xlsWriteLabel($xlsRow,28,$row['NipPJkelas']);
	xlsWriteLabel($xlsRow,29,$row['PengantarBhsAsing']);
	xlsWriteLabel($xlsRow,30,$row['HadirAktual']);
	xlsWriteLabel($xlsRow,31,$row['KehadiranSeharusnya']);
	xlsWriteLabel($xlsRow,32,$row['SatuanKehadiran']);
	xlsWriteLabel($xlsRow,33,$row['KehadiranAktualAsing']);
	xlsWriteLabel($xlsRow,34,$row['HadirAsing']);
	xlsWriteLabel($xlsRow,35,$row['SatuanHadirAsing']);
	xlsWriteLabel($xlsRow,36,$row['LintasFak']);
	xlsWriteLabel($xlsRow,37,$row['IkutHitung']);
	xlsWriteLabel($xlsRow,38,$row['KodePasca']);
	xlsWriteLabel($xlsRow,39,$row['SiakIdentifier']);
	xlsWriteLabel($xlsRow,40,$row['Hari']);
	xlsWriteLabel($xlsRow,41,$row['Jam']);
	xlsWriteLabel($xlsRow,42,$row['Ruang']);
	xlsWriteLabel($xlsRow,43,$row['flaghari']);
	$xlsRow++;
}
xlsEOF();
exit();
?>

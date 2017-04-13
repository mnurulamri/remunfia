<?
include('conn.php');

// Get data records from table.
$query = $_POST['query'];
$result = mysql_query($query);

header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");;
header("Content-Disposition: attachment;filename=absensi_pengajar_november_2011.xls ");
header("Content-Transfer-Encoding: binary ");
xlsBOF();

// Make column labels. (at line 3)
$xlsRow = 0;
for($i = 0; $i < mysql_num_fields($result); $i++){
	$col = mysql_field_name($result, $i);
	xlsWriteLabel($xlsRow,$i,$col);
}

// Put data records from mysql by while loop.
$xlsRow = 1;
while($rows = mysql_fetch_array($result)){
	for($i = 0; $i < mysql_num_fields($result); $i++){			
		$col = mysql_field_name($result, $i);
		xlsWriteLabel($xlsRow,$i,$rows[$col]);		
	}
	$xlsRow++;
}

xlsEOF();
exit();

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
?>
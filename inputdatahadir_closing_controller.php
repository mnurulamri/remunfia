<?php
//koneksi ke database
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();
$username = $_SESSION["username"];
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];

switch($vbulan)
{
	case "Januari":
		$bulan = "01";
		$hadiraktual = "hadirjanuari";
		$tahun_akad = $tahun - 1;
		$semester = 1;
		//$tahun = $tahun - 1;
		break;
	case "Februari":
		$bulan = "02";
		$hadiraktual = "hadirfebruari";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "Maret":
		$bulan = "03";
		$hadiraktual = "hadirmaret";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "April":
		$bulan = "04";
		$hadiraktual = "hadirapril";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "Mei":
		$bulan = "05";
		$hadiraktual = "hadirmei";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "Juni":
		$bulan = "06";
		$hadiraktual = "hadirjuni";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "Juli":
		$bulan = "07";
		$hadiraktual = "hadirjuli";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "Agustus":
		$bulan = "08";
		$hadiraktual = "hadiragustus";
		$tahun_akad = $tahun - 1;
		$semester = 2;
		break;
	case "September":
		$bulan = "09";
		$hadiraktual = "hadirseptember";
		$tahun_akad = $tahun;
		//$tahun = $tahun - 1;
		$semester = 1;
		break;
	case "Oktober":
		$bulan = "10";
		$hadiraktual = "hadiroktober";
		$tahun_akad = $tahun;
		//$tahun = $tahun - 1;
		$semester = 1;
		break;
	case "November":
		$bulan = "11";
		$hadiraktual = "hadirnovember";
		$tahun_akad = $tahun;
		//$tahun = $tahun - 1;
		$semester = 1;
		break;
	case "Desember":
		$bulan = "12";
		$hadiraktual = "hadirdesember";
		$tahun_akad = $tahun;
		//$tahun = $tahun - 1;
		$semester = 1;
		break;
}

$sql = "SELECT * FROM data_hadir_lock WHERE tahun = $tahun AND bulan = '$bulan'";
$result = mysql_query($sql) or die ("error: ".mysql_error());
$rows =  mysql_num_rows($result);

if($rows == 0){
	$sql = "INSERT INTO data_hadir_lock (tahun_akad, semester, tahun, bulan, lock_data) VALUES ('$tahun_akad', '$semester', '$tahun', '$bulan', '1')";
} else {
	$sql = "UPDATE data_hadir_lock SET lock_data = 1 WHERE tahun = $tahun AND bulan = '$bulan'";
}

$result = mysql_query ($sql) or die ("error: ".mysql_error());
?>
<?
if(!session_id()) session_start();
include("conn.php");

$kodeorganisasi = $_SESSION["kodeorganisasi"];

if(isset($_POST["tahun_akad"])){
	$_SESSION["tahun_akad"] = $_POST["tahun_akad"];
	$tahun_akad = $_POST["tahun_akad"];
}

if(isset($_POST["semester"])){
	$_SESSION["semester"] = $_POST["semester"];
	if($_POST["semester"] == "gasal"){
		$smt = 1;
	} else {
		$smt = 2;
	}
}

$pengajar = array();
$query = "SELECT distinct namapengajar FROM kalban WHERE $kodeorganisasi and tahun_akad=$tahun_akad and semester=$smt";
$sql = mysql_query($query);
while($row = mysql_fetch_array($sql)){
	array_push($pengajar, $row["namapengajar"]);
}

$MataKuliah = array();
$query = "SELECT distinct namamatakuliah FROM kalban WHERE $kodeorganisasi and tahun_akad=$tahun_akad and semester=$smt";
$sql = mysql_query($query);
while($row = mysql_fetch_array($sql)){
	array_push($MataKuliah, $row["namamatakuliah"]);
}

$_SESSION["pengajar"] = $pengajar;
$_SESSION["MataKuliah"] = $MataKuliah;

header( "Location: inputdatahadir.php");

?>
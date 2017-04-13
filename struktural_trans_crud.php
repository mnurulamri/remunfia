<?
/*
file ini untuk mengupdate pengajuan honor struktural tiap bulan berdasarkan program studi
*/

if(!session_id()) session_start();
$username = $_SESSION["username"];
if(!isset($_SESSION['username']) || empty($_SESSION['username']))	header("Location:index.php");

include 'conn.php';
if(!isset($_POST['tahun'])){$tahun='';} else {$tahun = $_POST['tahun'];}
if(!isset($_POST['bulan'])){$bulan='';} else {$bulan = $_POST['bulan'];}
if(!isset($_POST['id'])){$id='';} else {$id = $_POST['id'];}
if(!isset($_POST['nip'])){$nip='';} else {$nip = $_POST['nip'];}
if(!isset($_POST['tunjangan'])){$tunjangan=0;} else {$tunjangan = $_POST['tunjangan'];}
$kd_organisasi = $_SESSION['kode'];
if(!isset($_POST['oper'])){$oper='';} else {$oper = $_POST['oper'];}
$tunjangan = str_replace(',','',$tunjangan);

//buat ngetes -> echo 'tahun='.$tahun.' - bulan='.$bulan.' - tunjangan='.$tunjangan.' - id='.$id.' - kd_org='.$kd_organisasi.' - nip='.$nip.' - oper='.$oper;

if($oper==1){
	$sql = "INSERT INTO struktural_trans (tahun, bulan, kd_organisasi, nip, tunjangan)
			VALUES ($tahun, '$bulan', '$kd_organisasi', '$nip', $tunjangan)";
} else if($oper==2){
	$sql = "UPDATE struktural_trans
			SET tunjangan = $tunjangan
			WHERE id = $id";	
} else if($oper==3){
	$sql = "DELETE FROM struktural_trans
			WHERE id = $id";
}

$result = mysql_query($sql) or die(mysql_error());
?>
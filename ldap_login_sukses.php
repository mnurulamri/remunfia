<?php
if(!session_id()) session_start();
include 'conn.php';

if(!$_POST["role"]){
	header("location: ldap_login.php");
	exit;
}

/*-------------------------- lama ------------------------------
$temp = explode("-",$_POST["prodi"]);
$kode = trim($temp[0]);
$hak_akses = trim($temp[1]);

echo $kode.' - '.$hak_akses.' - '.$_SESSION['username'];
---------------------------------------------------------------*/

$nip = $_SESSION['user_nip'];
$role = $_POST['role'];

if(strlen($role) > 2){ 
	//jika yang dipilih prodi maka role = kode program studi
	$sql = "SELECT a.*, b.*, c.* 
			FROM user_role a INNER JOIN user_permission b ON a.user_nip = b.user_nip 
				INNER JOIN organisasi c ON permission = kodeorganisasi
			WHERE kodeorganisasi = '$role' AND role_id = 2";
	$_SESSION['hak_akses'] = 2;
	$_SESSION['permission'] = $_POST['role'];
	data($sql);
} else if($role == 4){ 
	//jika yang dipilih PPAA maka role = PPAA
	$sql = "SELECT a.*, b.*, c.* 
			FROM user_role a INNER JOIN user_permission b ON a.user_nip = b.user_nip 
				INNER JOIN organisasi c ON permission = kodeorganisasi
			WHERE kodeorganisasi = '01.00.09.01' AND role_id = 2";
	$_SESSION['hak_akses'] = 2;	//dirubah menjadi 2 supaya menunya sama kaya menu prodi
	data($sql);
}  else if($role == 1){ 
	//jika yang dipilih admin maka role = admin
	$sql = "SELECT a.*, b.*, c.* 
			FROM user_role a INNER JOIN user_permission b ON a.user_nip = b.user_nip 
				INNER JOIN organisasi c ON permission = kodeorganisasi
			WHERE kodeorganisasi = '00.00.09.01' AND role_id = 1";
	$_SESSION['hak_akses'] = 1;	//untuk admin
	data($sql);
} else {
	$_SESSION['hak_akses'] = $_POST['role'];
	$_SESSION['programstudi'] = 'Dosen';
	$_SESSION['nip'] = $nip;
}



/*echo "programstudi = ".$_SESSION["programstudi"].'<br>';
echo 'hak_akses d = '.$_SESSION['hak_akses'].'<br>';
echo 'username d = '.$_SESSION['username'].'<br>';
echo 'nip d = '.$_SESSION['user_nip'];*/

header("location: a.php");
exit;

function data($sql){
	$result = mysql_query($sql) or die(mysql_error());

	while($row = mysql_fetch_array($result)){
		$_SESSION["kode"] = $row["kodeorganisasi"]; 
		$_SESSION["kd_organisasi"] = $row["kodeorganisasi"];
		$_SESSION["kodeorganisasi"] = $row["query1"];
		$_SESSION["orderby"] = $row["query2"]; 
		$_SESSION["programstudi"] = $row["programstudi"];
		$_SESSION["ketuaprogram"] = $row["ketuaprogramstudi"]; 
		$_SESSION["nip"] = $row["nip"];
		//$_SESSION['hak_akses'] = $hak_akses;
		
		/*echo 'kode = '.$_SESSION["kode"].'<br>';
		echo "kd_organisasi = ".$_SESSION["kd_organisasi"].'<br>';
		echo "kodeorganisasi = ".$_SESSION["kodeorganisasi"].'<br>';
		echo "orderby = ".$_SESSION["orderby"].'<br>';
		echo "programstudi = ".$_SESSION["programstudi"].'<br>';
		echo "ketuaprogramstudi = ".$_SESSION["ketuaprogramstudi"].'<br>';
		echo "nip = ".$_SESSION["nip"].'<br>';
		echo 'hak_akses = '.$_SESSION['hak_akses'].'<br>';
		echo 'username = '.$_SESSION['username'];*/
	}
}
?>
<link rel="icon" type="image/ico" href="Rupiah.ico"></link>
<link rel="shortcut icon" href="images/Rupiah.ico"></link>
<?php
include ("conn.php");
if(!session_id()) session_start();

$username = $_POST["username"];
$password = $_POST["password"];

#protect mwsql injection
$usename = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);

//------------------------------------------------- tambahan LDAP -----------------------------------------------------------------//
//$conn = @ldap_connect('ldap://152.118.39.37', 389); //ldap ui, belum bisa dari ppl.cs.ui.ac.id
$conn = @ldap_connect('ldap://152.118.39.37', 389); //ldap fasilkom
$opt = @ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
// jika berhasil konek
if($conn) {
	// $filter = "uid='" . $username . "'";
	$filter = "uid=" . $username;
	$base_dn = "o=Universitas Indonesia,c=ID";
	$result = @ldap_search($conn, $base_dn, $filter);
	if (!$result) {
		echo 'error_gagal_konek';
	} else {
		//$_SESSION['username'] = $username;
		//header("location:ldap_login_cek.php");
	}
	
	//$result = ldap_search($conn, "o=Universitas Indonesia,c=ID", $filter);
	$info = ldap_get_entries($conn, $result);
	
	/*-------- edit ------------
	$DN = $info[0]["dn"];
	$ret = @ldap_bind($conn, $DN, $password);
	
	if($info['count'] == 0 OR !$ret) {
		//error username & password -> redirect ke halaman index
		header("location:ldap_login.php");		

	} else {
		$_SESSION['nip'] = $info[0][15];
		header("location:ldap_login_cek.php");
	}
	--------------------------*/
	
	/*--------------- asli ------------------------------*/
	if($info['count'] == 0) {
		ldap_close($conn);
		//error username -> redirect ke halaman index
		header("location:ldap_login.php");
		exit;
	}
	
	$DN = $info[0]["dn"];
	$ret = @ldap_bind($conn, $DN, $password);
	$user_nip = $info[0]['kodeidentitas'][0];
	$username = $info[0]['uid'][0];
	
	if(!$ret) {
		//error password -> redirect ke halaman index
		header("location:ldap_login.php");
		exit;
	} else {
		$_SESSION['user_nip'] = $user_nip;
		$_SESSION['username'] = $username;
		$_SESSION['token'] = md5('unique_salt' . time());
		header("location:ldap_login_cek.php");
		exit;
	}
	/*----------------------------------------------------*/ 
	
	ldap_close($conn);
	//echo 'Info: '.$info[0];
} else {
	ldap_close($conn); //koneksi gagal
	echo 'error_gagal_konek';
}
//---------------------------------------------------------------------------------------------------------------------------------//

?>				


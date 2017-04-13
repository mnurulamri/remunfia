<?php
// user dan password user yang sudah terdaftar di server LDAP  
$username  = '';  
$password = '';  


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
		return 'error_gagal_konek';
	}
	// $result = ldap_search($conn, "o=Universitas Indonesia,c=ID", $filter);
	$info = ldap_get_entries($conn, $result);
	if($info['count'] == 0) {
		ldap_close($conn);
		return 'error_username'; //ngga ada username
	}
	$DN = $info[0]["dn"];
	$ret = @ldap_bind($conn, $DN, $password);
	ldap_close($conn);
	if(!$ret) {
		return 'error_password';
	}
	return $info[0];
} else {
	ldap_close($conn); //koneksi gagal
	return 'error_gagal_konek';
}
	
?>
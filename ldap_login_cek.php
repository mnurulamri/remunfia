<link rel="icon" type="image/ico" href="Rupiah.ico"></link>
<link rel="shortcut icon" href="images/Rupiah.ico"></link>
<?php
include ("conn.php");
if(!session_id()) session_start();
//include('token.php');
//checkToken();
/*-------------------------------------------------
$username = $_POST["username"];
$password = $_POST["password"];

#protect mwsql injection
$usename = stripslashes($username);
$password = stripslashes($password);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
---------------------------------------------------*/

/*--------------- buat ngetes aja --------------------
$_SESSION['user_nip'] = '090613091';
//testing..
$user_nip = '090903011'; 
$_SESSION['user_nip'] = '090903011';
$_SESSION['username'] = 'mnurulamri';
-------------------------------------------------*/

if ($_SESSION['username'] == 'mailan'){
	$user_nip = $_SESSION['username'];
	$_SESSION['user_nip'] = $user_nip;
} else {
	$user_nip = $_SESSION['user_nip'];
}

$sql = "SELECT a.user_nip as user_nip, a.role_id as role_id, permission, programstudi, role, c.program as program, c.prodi as prodi
		FROM user_role a 
			LEFT JOIN user_permission b ON a.user_nip = b.user_nip 
			LEFT JOIN organisasi c  ON permission = kodeorganisasi
			INNER JOIN role d ON a.role_id = d.role_id
		WHERE a.user_nip = '$user_nip'
		ORDER BY role";
$hasil = mysql_query($sql);
$data = '';
$data = array();

while($row = mysql_fetch_object($hasil)) {
	$data[$row->role_id][$row->role][] = $row;
}	
?>

<html>
<head>
<title>Pilih Role - Sistem Informasi Remunerasi Pengajar FISIP UI</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body style="text-align:center">
<div style="width:100%; margin-left:auto; margin-right:auto; text-align:right;">
	<a href='ldap_logout.php'><img src="logout1.png" onmouseover="this.src='logout2.png';" onmouseout="this.src='logout1.png';" height=40 width=40/></a>
</div>
<div class="raised">
	<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
	<div class="boxcontent">
		<h1 style="color:#ddd">Anda Login sebagai:</h1>
	</div>
	<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>

<form name="form" action="ldap_login_sukses.php" method="post">

<?php 
foreach($data as $kRoleID => $vRoleID){
	
	foreach ($vRoleID as $kRole => $vRole){

		if($kRoleID == 2){
			echo '<br>';
			box1();
			echo'
			<h2 onmouseout="this.style.backgroundColor=\'#ccc\'; this.style.color=\'555555\';" onmouseover="this.style.color=\'#FF6600\';">
				<dt>'.$kRole.'</dt>
			</h2>

			<div class="boxcontent">';
			
			foreach ($vRole as $v){
				$nip = $v->user_nip; 
				$permission = $v->permission;
				$hak_akses = $v->role_id;
				$akses_ke = $v->program.' '.$v->prodi;
				$role = $v->role;			
				
				if($permission != '00.00.09.01' AND $permission != '01.00.09.01' AND $user_nip!='090613091'){ //jika bukan admin
					
					echo'		
					<h2 style="font-size:13px"; onmouseout="this.style.backgroundColor=\'#ccc\'; this.style.color=\'#555555\';" onmouseover="this.style.color=\'#FF6600\';">
						<dt><input type="radio" name="role" value="'.$permission.'"/>'.$akses_ke.'</dt>
					</h2>';	
					
				} else if($permission != '00.00.09.01' AND $permission != '01.00.09.01' AND $user_nip=='090613091'){
				
					echo'
					<div style="font-size:12px; font-family:verdana; color:#444; border-left:1px solid blue" onmouseover="this.style.color=\'#FF6600\';" onmouseout="this.style.color=\'#444\'">
						<dt style="width:50%; margin-left:0; margin-right:0; text-align:left; float:left;">
							<input type="radio" name="role" value="'.$permission.'"/>'.$akses_ke.'
						</dt>
					</div>';					
				}
							
			}
			//echo '</div>';
			box2();
		} else {
			echo '<br>';
			box1();
			echo'
			<h2 onmouseout="this.style.backgroundColor=\'#ccc\'; this.style.color=\'555555\';" onmouseover="this.style.color=\'#FF6600\';">
				<dt><input type="radio" name="role" value="'.$kRoleID.'"/>'.$kRole.'</dt>
			</h2>';
			box2();
		}
	}
}
?>
		
<br>
<div align="center">
	<input type="submit" name="submit" value="lanjut"/>
</div>
</form>
</body>
</html>
<?
function box1(){
	echo "
		<div class='inset'>
			<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
			<div class='boxcontent'>	
		"
	;
}

function box2(){
	echo "			
			</div>
			<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
		</div>
		"
	;
}

?>

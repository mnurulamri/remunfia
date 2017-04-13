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
$password = md5(base64_encode($password));

$sql = "select * from organisasi where username = '$username' and password = '$password'";
$hasil = mysql_query($sql);
$data = array();

while($row = mysql_fetch_array($hasil)) {
	array_push($data, $row);
	$_SESSION["kode"] = $row["kodeorganisasi"]; 
	$_SESSION["kd_organisasi"] = $row["kodeorganisasi"];
	$_SESSION["kodeorganisasi"] = $row["query1"];
	$_SESSION["orderby"] = $row["query2"]; 
	$_SESSION["programstudi"] = $row["programstudi"];
	$_SESSION["ketuaprogramstudi"] = $row["ketuaprogramstudi"]; 
	$_SESSION["nip"] = $row["nip"];
	$_SESSION["hak_akses"] = $row["hak_akses"];
}	

$_SESSION["data"] = $data;

#cek apakah data absensi pengajarannya ada..
$jmlbaris = mysql_num_rows($hasil);
if ($jmlbaris > 0){
	$_SESSION["username"] = $username;
	$_SESSION["password"] = $password;
	$kodeorganisasi = $_SESSION["kodeorganisasi"];
	$orderby = $_SESSION["orderby"];
	$sql = "select *
			from kalban
			where $kodeorganisasi and flagtampil = 1 and tahun = 2015
			order by $orderby";			
	$_SESSION["sql"] = $sql;		
	#header("location: login_sukses.php");
} else {
	echo "<script language='JavaScript'>alert('Username atau password Anda salah');
		          document.location='index.php'
		  </script>";
}
?>

<html>
<head>
<title>sistem Informasi Remunerasi Pengajar FISIP UI</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body style="text-align:center">
<div style="width:100%; margin-left:auto; margin-right:auto; text-align:right;">
	<a href='logout.php'><img src="logout1.png" onmouseover="this.src='logout2.png';" onmouseout="this.src='logout1.png';" height=40 width=40/></a>
</div>
<p></p><br><br>
<p></p>
<div class="raised">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="boxcontent">
<h1>Anda Login sebagai:</h1>
</div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
</div>
<p></p>

<form name="form" action="login_sukses.php" method="post">

<?php 
$username = $_SESSION["username"];
box1();

foreach($_SESSION["data"] as $baris){
	$kode = $baris[1];
	$kd_organisasi = $baris[1];
	$kodeorganisasi = $baris[10];
	$programstudi = $baris[5];
	$nip = $baris[7];
	$ketuaprogram = $baris[6];
	$hak_akses = $baris[12];

	if ($username == "mailanur" or $username == "joko"){?>		
		<h2 onmouseout="this.style.backgroundColor='#ccc'; this.style.color='555555';" onmouseover="this.style.color='#FF6600';">		
		<input type="radio" name="prodi" value="<? echo $kode ?>"/>
		<?echo $programstudi?></h2>
	<?} else {
		$_SESSION["kd_organisasi"] = $kd_organisasi;
		$_SESSION["kodeorganisasi"] = $kodeorganisasi;
		echo "<h1>".$programstudi."</h1>";
	}
}

#setting session program studi..
$_SESSION["programstudi"] = $programstudi;
$_SESSION["nip"] = $nip;
$_SESSION["ketuaprogram"] = $ketuaprogram;

box2();

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
				<p></p>
			</div>
			<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
		</div>
		"
	;
}

?>				
<br>
<div align="center">
<input type="submit" name="submit" value="lanjut"/>
</div>
</form>
</body>
</html>

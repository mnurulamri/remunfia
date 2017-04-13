<?php

if(!session_id()) session_start();
include("conn.php");
include("bulan.php");

$oper = $_POST["oper"];
$tahun = $_POST["tahun"];
$bulan = $_POST["bulan"];
$nip = $_POST["nip"];
$jabatan = $_POST["jabatan"];
$kd_organisasi = $_SESSION["kode"];
$tunjangan = $_POST["vtunjangan"];
$periode = $_POST["periode"];
 
if ($oper == "edit" or $oper == "del") $id = $_POST['id'];

switch ($oper) 
{	
	case 'add':
		
		$q = mysql_query("INSERT INTO struktural (tahun, bulan, kd_organisasi, nip, jabatan, tunjangan, periode)
					      VALUES($tahun,'$bulan', '$kd_organisasi','$nip','$jabatan',$tunjangan,'$periode')");
		
		break;
	
	case 'edit':
		
		$q = mysql_query("UPDATE struktural 
						  SET jabatan = '$jabatan',
						      tunjangan = $tunjangan,
							  periode = '$periode'
						  WHERE id = $id");
		/*
		($q){
			echo "Update Sukses";
		}
		*/
		break;
	
	case 'del':
		
		$q = mysql_query("DELETE FROM struktural WHERE id = $id");
	
	break;

}		
?>

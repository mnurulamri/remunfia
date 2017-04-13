<?
if(!session_id()) session_start();

include 'conn.php';
$id				= $_POST['id'];
$oper			= $_POST['oper'];
$kd_organisasi 	= $_SESSION['kd_organisasi'];
$nip 			= $_POST['nip'];
$jabatan 		= $_POST['jabatan'];
$tunjangan 		= $_POST['tunjangan'];
$no_sk 			= $_POST['no_sk'];
$vtgl_awal 		= $_POST['tgl_awal'];
$vtgl_akhir 	= $_POST['tgl_akhir'];

/*$tgl_awal = date('Y-m-d',strtotime($vtgl_awal)); 
$tgl_akhir = date('Y-m-d',strtotime($vtgl_akhir));*/
//operasi tanggal
$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$tgl_awal_arr = explode(" ",$vtgl_awal);
$d = $tgl_awal_arr[0]; 
$m = array_search($tgl_awal_arr[1], $bulan)+1; 
$y = $tgl_awal_arr[2];
$tgl_awal = $y."-".$m."-".$d;

$bulan = array('Januari','Februari','Maret','April','Mei', 'Juni','Juli','Agustus','September','Oktober','November','Desember');
$tgl_akhir_arr = explode(" ",$vtgl_akhir);
$d = $tgl_akhir_arr[0]; 
$m = array_search($tgl_akhir_arr[1], $bulan)+1; 
$y = $tgl_akhir_arr[2];
$tgl_akhir = $y."-".$m."-".$d;

if ($oper == 1){
	$sql = "INSERT INTO struktural (kd_organisasi, nip, jabatan, tunjangan, no_sk, tgl_awal, tgl_akhir) 
			VALUES ('$kd_organisasi', '$nip', '$jabatan', '$tunjangan', '$no_sk', '$tgl_awal', '$tgl_akhir')";
} else if ($oper == 2){
	$sql = "UPDATE struktural
			SET nip = '$nip',
				jabatan = '$jabatan',
				tunjangan = $tunjangan,
				no_sk = '$no_sk',
				tgl_awal = '$tgl_awal',
				tgl_akhir = '$tgl_akhir'
				WHERE id = '$id'";
} else if ($oper == 3){
	$sql = "DELETE FROM struktural WHERE id = $id";
}

$result = mysql_query($sql) or die(mysql_error());

/*echo $oper.' '.$id.' '.$kd_organisasi.' '.$nip.' '.$jabatan.' '.$tunjangan.' '.$no_sk.' '.$vtgl_awal.' '.$vtgl_akhir;*/
?>
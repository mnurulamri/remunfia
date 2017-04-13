<?
//include("../../remun/conn.php");

//inisialisasi
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];

//set bulan dan tahun akademik
switch($vbulan)
{
	case "Januari":
		$bulan = "01";
		$tahun_akad = $tahun;
		break;
	case "Februari":
		$bulan = "02";
		$tahun_akad = $tahun - 1;
		break;
	case "Maret":
		$bulan = "03";
		$tahun_akad = $tahun - 1;
		break;
	case "April":
		$bulan = "04";
		$tahun_akad = $tahun - 1;
		break;
	case "Mei":
		$bulan = "05";
		$tahun_akad = $tahun - 1;
		break;
	case "Juni":
		$bulan = "06";
		$tahun_akad = $tahun - 1;
		break;
	case "Juli":
		$bulan = "07";
		$tahun_akad = $tahun - 1;
		break;
	case "Agustus":
		$bulan = "08";
		$tahun_akad = $tahun;
		break;
	case "September":
		$bulan = "09";
		$tahun_akad = $tahun;
		break;
	case "Oktober":
		$bulan = "10";
		$tahun_akad = $tahun;
		break;
	case "November":
		$bulan = "11";
		$tahun_akad = $tahun;
		break;
	case "Desember":
		$bulan = "12";
		$tahun_akad = $tahun;
		break;
}

//reset total
$total_xf = 0;
$ts_inti_penelitian = 0;
$total_sks = 0;
$tot_sks_siak = 0;
$tot_sks_ok = 0;
$potongan = 0;

//cek data yang akan diinput sudah ada atau belum, jika sudah ada maka data akan dihapus dan diganti dengan data yang baru diupload
$sql = "DELETE FROM gaji_detail WHERE tahun = $tahun AND bulan = '$bulan'";
$result = mysql_query($sql);

// membaca file excel yang diupload
echo 'Nama File = '.$fileName;
require_once "simplexlsx.class.php";
$xlsx = new SimpleXLSX( $_FILES['userfile']['tmp_name'] );
$excel = array(array());
$excel = $xlsx->rows(1); //mulai baris kedua karena baris pertamanya judul kolom

// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
$sukses = 0;
$gagal = 0;
$j = 0;
echo "
<br>
<div class='inset' text-align:center;>
	<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
		<div class='boxcontent' text-align:center;>
			<div style='font-family:arial; font-size:10px; font-weight:bold; text-align:center; color:#555545;'>
				<p style='text-align:center;'>
					<label>Log Import</label><br>
					<table style=\"width=80%; margin:auto\">
						
";


//untuk masing2 baris
for($i=1; $i<sizeof($excel); $i++){ //mulai dari baris kedua
	// membaca data				
	$Periode = $excel[$i][0];
	$nip = $excel[$i][1];
	$Nama_Dosen = $excel[$i][2];
	$Jenis_Pegawai = $excel[$i][3];
	$Jabatan_Fungsional= $excel[$i][4];
	$NPWP = $excel[$i][5];
	$Skema_Dosen = $excel[$i][6];
	$total_sks = $excel[$i][7];
	$dk_bhmn = $excel[$i][8];
	$ts_kesehatan= $excel[$i][9];
	$ts_inti_pengajaran= $excel[$i][10];
	$ts_inti_penelitian= $excel[$i][11];
	$ts_struktural = $excel[$i][12];
	$xu_skema_inti = $excel[$i][13];
	$xf_skema_inti = $excel[$i][14];
	$xf_skema_lain= $excel[$i][15];
	$xf_lintas_fak = $excel[$i][16];
	$honor_bhs_asing = $excel[$i][17];
	$honor_bimbingan = $excel[$i][18];
	$tj_saf = $excel[$i][19];
	$tj_inti_pengajaran= $excel[$i][20];
	$insentif_khusus = $excel[$i][21];
	$kl_bayar = $excel[$i][22];
	$tj_pajak = $excel[$i][23];
	$honor_bruto = $excel[$i][24];
	$pajak = $excel[$i][25];
	$honor_neto = $excel[$i][26];
	$potongan = $excel[$i][27];
	$tunda_bayar = $excel[$i][28];
	$jml_ditransfer = $excel[$i][29];
	$nama_rekening  = $excel[$i][30];
	$nama_bank  = $excel[$i][31];
	$no_rekening  = $excel[$i][32];

	
	//rubah nilai null
	if (empty($total_sks)) $total_sks = 0;
	if (empty($dk_bhmn)) $dk_bhmn = 0;
	if (empty($ts_kesehatan)) $ts_kesehatan = 0;
	if (empty($ts_inti_pengajaran)) $ts_inti_pengajaran = 0;
	if (empty($ts_inti_penelitian)) $ts_inti_penelitian = 0;
	if (empty($ts_struktural)) $ts_struktural = 0;
	if (empty($xu_skema_inti)) $xu_skema_inti = 0;
	if (empty($xf_skema_inti)) $xf_skema_inti = 0;
	if (empty($xf_skema_lain)) $xf_skema_lain= 0;
	if (empty($xf_lintas_fak)) $xf_lintas_fak = 0;
	if (empty($honor_bhs_asing)) $honor_bhs_asing = 0;
	if (empty($honor_bimbingan)) $honor_bimbingan = 0;
	if (empty($tj_saf)) $tj_saf = 0;
	if (empty($tj_inti_pengajaran)) $tj_inti_pengajaran = 0;
	if (empty($insentif_khusus)) $insentif_khusus = 0;
	if (empty($kl_bayar)) $kl_bayar = 0;
	if (empty($tj_pajak)) $tj_pajak = 0;
	if (empty($honor_bruto)) $honor_bruto = 0;
	if (empty($pajak)) $pajak = 0;
	if (empty($honor_neto)) $honor_neto = 0;
	if (empty($potongan)) $potongan = 0;
	if (empty($tunda_bayar)) $tunda_bayar = 0;
	if (empty($jml_ditransfer)) $jml_ditransfer = 0;
	if (empty($nama_rekening)) $nama_rekening  = "";
	if (empty($nama_bank)) $nama_bank  = "";
	if (empty($no_rekening)) $no_rekening  = "";
	
	$nama_rekening = addslashes($nama_rekening);
	$total_xf = $xf_skema_inti + $xf_skema_lain + $xf_lintas_fak;
	
  // setelah data dibaca, sisipkan ke dalam tabel gaji_detail
  $query = "INSERT INTO gaji_detail (
				tahun_akad,
				tahun,
				bulan,
				nip,
				total_sks,
				dk_bhmn,
				ts_kesehatan,
				ts_inti_pengajaran,
				ts_inti_penelitian,
				ts_struktural,
				xu_skema_inti,
				xf_skema_inti,
				xf_skema_lain,
				xf_lintas_fak,
				honor_bhs_asing,
				honor_bimbingan,
				tj_saf,
				tj_inti_pengajaran,
				insentif_khusus,
				kl_bayar,
				tj_pajak,
				honor_bruto,
				pajak,
				honor_neto,
				potongan,
				tunda_bayar,
				jml_ditransfer,
				nama_rekening,
				nama_bank,
				no_rekening,
				total_xf)
				
			VALUES (
				$tahun_akad,
				$tahun,
				'$bulan',
				'$nip',
				$total_sks,
				$dk_bhmn,
				$ts_kesehatan,
				$ts_inti_pengajaran,
				$ts_inti_penelitian,
				$ts_struktural,
				$xu_skema_inti,
				$xf_skema_inti,
				$xf_skema_lain,
				$xf_lintas_fak,
				$honor_bhs_asing,
				$honor_bimbingan,
				$tj_saf,
				$tj_inti_pengajaran,
				$insentif_khusus,
				$kl_bayar,
				$tj_pajak,
				$honor_bruto,
				$pajak,
				$honor_neto,
				$potongan,
				$tunda_bayar,
				$jml_ditransfer,
				'$nama_rekening',
				'$nama_bank',
				'$no_rekening',
				$total_xf)";
				
	$hasil = mysql_query($query) or die(mysql_error());
	
	// jika proses insert data sukses, maka counter $sukses bertambah
	// jika gagal, maka counter $gagal yang bertambah
	$hasil = true;
	if ($hasil){
	$sukses++;
	#echo "<tr style='color:green; font-weight:bold'; font-size:7px; font-family:arial'><td>".$j."</td><td>".$d5."</td><td>sukses</td></tr>";
	} else {
	$gagal++;	
	echo "
	<th bgcolor='lightorange'>No</th><th>NIP</th><th>Upload</th>
	<tr style='padding-left:10px; vertical-align:middle; font:bold 11px verdana; border:1px solid orange;'><td>".$j + 1 ."</td><td>".$nip."</td><td>gagal</td></tr>
	";
	}

}

echo "</table>";

// tampilan status sukses dan gagal
echo "
<p><b>Proses import data selesai<b></br>
Jumlah data yang sukses diimport : ".$sukses."<br>
Jumlah data yang gagal diimport : ".$gagal."</p>
				</p>
			</div>
		</div>
	<b class='b4b'></b><b class='b3b'></b><b class='b2b'></b><b class='b1b'></b>
</div>
";
?>
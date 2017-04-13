<?php
// menggunakan class phpExcelReader
include("excel_reader2.php");

// koneksi ke mysql
//include("conn.php");
//include("import_gaji_interface.php");
//inisialisasi
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];
echo $tahun.' '.$vbulan;


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
$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

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
// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	$j++;
	// membaca data
	$Periode = $data->val($i,1);
	$nip = $data->val($i,2);
	$Nama_Dosen = $data->val($i,3);
	$Jenis_Pegawai = $data->val($i,4);
	$Jabatan_Fungsional= $data->val($i,5);
	$NPWP = $data->val($i,6);
	$Skema_Dosen = $data->val($i,7);
	$total_sks = $data->val($i,8);
	$dk_bhmn = $data->val($i,9);
	$ts_kesehatan= $data->val($i,10);
	$ts_inti_pengajaran= $data->val($i,11);
	$ts_inti_penelitian= $data->val($i,12);
	$ts_struktural = $data->val($i,13);
	$xu_skema_inti = $data->val($i,14);
	$xf_skema_inti = $data->val($i,15);
	$xf_skema_lain= $data->val($i,16);
	$xf_lintas_fak = $data->val($i,17);
	$honor_bhs_asing = $data->val($i,18);
	$honor_bimbingan = $data->val($i,19);
	$tj_saf = $data->val($i,20);
	$tj_inti_pengajaran= $data->val($i,21);
	$insentif_khusus = $data->val($i,22);
	$kl_bayar = $data->val($i,23);
	$tj_pajak = $data->val($i,24);
	$honor_bruto = $data->val($i,25);
	$pajak = $data->val($i,26);
	$honor_neto = $data->val($i,27);
	$potongan = $data->val($i,28);
	$tunda_bayar = $data->val($i,29);
	$jml_ditransfer = $data->val($i,30);
	$nama_rekening  = $data->val($i,31);
	$nama_bank  = $data->val($i,32);
	$no_rekening  = $data->val($i,33);

	
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
  if ($hasil){
	$sukses++;
	#echo "<tr style='color:green; font-weight:bold'; font-size:7px; font-family:arial'><td>".$j."</td><td>".$d5."</td><td>sukses</td></tr>";
  } else {
	$gagal++;	
	echo "
	<th bgcolor='lightorange'>No</th><th>NIP</th><th>Upload</th>
	<tr style='padding-left:10px; vertical-align:middle; font:bold 11px verdana; border:1px solid orange;'><td>".$j + 1 ."</td><td>".$nip."</td><td>gagal</td></tr>";
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
	<style>
		table {border:1px solid #FCC; border-collapse:collapse; font-family:arial,sans-serif; font-size:100%; text-align:center;}
		td,th {border:1px solid #FCC; border-collapse:collapse; padding:5px;}
		table th {background:#999;}
	</style>
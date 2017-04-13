<?php
//koneksi ke database
if(!session_id()) session_start();
include("conn.php");
$username = $_SESSION["username"];
#setting session, hadir aktual, tahun dan bulan

$kodeorganisasi = $_SESSION["kodeorganisasi"];
$_SESSION["tahun"] = $_POST["tahun"];
$_SESSION["bulan_gasal"] = $_POST["bulan_gasal"];
$tahun = $_SESSION["tahun"];
$bulan_gasal = $_SESSION["bulan_gasal"];
$nip = $_POST["nip"];
$namapengajar = $_POST["namapengajar"];

if(isset($bulan_gasal))$bulan = $bulan_gasal;

switch($bulan)
{
	case "Januari":
		$periode_bulan = "01";
		$hadiraktual = "hadirjanuari";
		break;
	case "Februari":
		$periode_bulan = "02";
		$hadiraktual = "hadirfebruari";
		break;
	case "Maret":
		$periode_bulan = "03";
		$hadiraktual = "hadirmaret";
		break;
	case "April":
		$periode_bulan = "04";
		$hadiraktual = "hadirapril";
		break;
	case "Mei":
		$periode_bulan = "05";
		$hadiraktual = "hadirmei";
		break;
	case "Juni":
		$periode_bulan = "06";
		$hadiraktual = "hadirjuni";
		break;
	case "Juli":
		$periode_bulan = "07";
		$hadiraktual = "hadirjuli";
		break;
	case "Agustus":
		$periode_bulan = "08";
		$hadiraktual = "hadiragustus";
		break;
	case "September":
		$periode_bulan = "09";
		$hadiraktual = "hadirseptember";
		break;
	case "Oktober":
		$periode_bulan = "10";
		$hadiraktual = "hadiroktober";
		break;
	case "November":
		$periode_bulan = "11";
		$hadiraktual = "hadirnovember";
		break;
	case "Desember":
		$periode_bulan = "12";
		$hadiraktual = "hadirdesember";
		break;
}

if($hak_akses = 3){

	require('draw.php');

	#ambil data di tabel dan masukkan ke array
	$judullaporan = "Slip Gaji Dosen Periode $bulan $tahun";
	$_SESSION["judullaporan"] = $judullaporan;

	$bulantahun = $periode_bulan.$tahun;

	#ambil data dosen
	$query = "SELECT  a.nip as nip,
			a.nama_pengajar as nama_pengajar,
			a.induk_fakultas as induk_fakultas,
			a.status_pegawai as status_pegawai,
			a.jabatan_fungsional as jabatan_fungsional,
			a.npwp as npwp,
			a.skema as skema,
			a.status_nikah as status_nikah,
			a.golongan as golongan,
			c.tot_sks_siak as tot_sks_siak,
			c.tot_sks_ok as tot_sks_ok,
			c.dk_bhmn as dk_bhmn,
			c.ts_kesehatan as ts_kesehatan,
			c.ts_inti_pengajaran as ts_inti_pengajaran,
			c.ts_inti_penelitian as ts_inti_penelitian,
			c.ts_struktural as ts_struktural,
			c.xu_skema_inti as xu_skema_inti,
			c.xf_skema_inti as xf_skema_inti,
			c.xf_skema_lain as xf_skema_lain,
			c.xf_lintas_fak as xf_lintas_fak,
			c.honor_bhs_asing as honor_bhs_asing,
			c.honor_bimbingan as honor_bimbingan,
			c.tj_saf as tj_saf,
			c.tj_inti_pengajaran as tj_inti_pengajaran,
			c.insentif_khusus as insentif_khusus,
			c.kl_bayar as kl_bayar,
			c.tj_pajak as tj_pajak,
			c.honor_bruto as honor_bruto,
			c.pajak as pajak,
			c.honor_neto as honor_neto,
			c.potongan as potongan,
			c.tunda_bayar as tunda_bayar,
			c.jml_ditransfer as jml_ditransfer,
			c.nama_rekening as nama_rekening,
			c.nama_bank as nama_bank,
			c.no_rekening as no_rekening,
			c.total_xf as total_xf
	FROM    pengajar a, gaji_detail c 
	WHERE   a.nip = '$nip' and c.nip = a.nip and c.tahun = $tahun and c.bulan = '$periode_bulan' and a.tahun=c.tahun and a.bulan=c.bulan";
				
	$sql = mysql_query ($query) or die ("error data pengajar: ".mysql_error());
	while ($row = mysql_fetch_array($sql)) {
		$nip =$row["nip"];
		$nama_pengajar =$row["nama_pengajar"];
		$induk_fakultas=$row["induk_fakultas"];
		$status_pegawai=$row["status_pegawai"];
		$jabatan_fungsional =$row["jabatan_fungsional"];
		$npwp =$row["npwp"];
		$skema =$row["skema"];
		$status_nikah = $row["status_nikah"];
		$golongan = $row["golongan"];
		$totskssiak=$row["tot_sks_siak"];
		$totsksok=$row["tot_sks_ok"];
		$dk_bhmn =$row["dk_bhmn"];
		$ts_kesehatan =$row["ts_kesehatan"];
		$ts_inti_pengajaran =$row["ts_inti_pengajaran"];
		$ts_inti_penelitian =$row["ts_inti_penelitian"];
		$ts_struktural =$row["ts_struktural"];
		$xu_skema_inti =$row["xu_skema_inti"];
		$xf_skema_inti=$row["xf_skema_inti"];
		$xf_skema_lain =$row["xf_skema_lain"];
		$xf_lintas_fak =$row["xf_lintas_fak"];
		$honor_bhs_asing =$row["honor_bhs_asing"];

		$honor_bimbingan =$row["honor_bimbingan"];
		$tj_saf =$row["tj_saf"];
		$tj_inti_pengajaran =$row["tj_inti_pengajaran"];
		$insentif_khusus =$row["insentif_khusus"];
		$kl_bayar =$row["kl_bayar"];
		$tj_pajak =$row["tj_pajak"];
		$honor_bruto =$row["honor_bruto"];
		$pajak =$row["pajak"];
		$honor_neto =$row["honor_neto"];
		$potongan =$row["potongan"];
		$tunda_bayar =$row["tunda_bayar"];
		$jml_ditransfer =$row["jml_ditransfer"];
		$nama_rekening =$row["nama_rekening"];
		$nama_bank =$row["nama_bank"];
		$no_rekening =$row["no_rekening"];
		$total_xf =$row["total_xf"];
		$honor_struktural = $ts_struktural + $insentif_khusus;
		$tot_xf_skema_lain = $xf_skema_lain + $xf_lintas_fak;
	}

	$tj_jabatan = $tj_inti_pengajaran + $insentif_khusus;

	switch ($skema){
		case 0: 
			$skema = "Skema Lain";
			break;
		case 1: 
			$skema = "Skema Inti Pengajaran";
			break;
		case 2: 
			$skema = "Skema Inti Penelitian";
			break;
		case 3: 
			$skema = "Skema Struktural";
			break;
	}

	#sertakan library FPDF dan bentuk objek
	require_once ("../remun/fpdf/fpdf.php");

	#tampilkan judul laporan
	class PDF extends FPDF
	{
	//Page header
		function Header()
		{
			$this->Image('images/makara_gold.jpg',10,5,13);
			$this->SetY(6);
			$this->Cell(15);
			$this->SetFont('Arial','B','9');
			$this->Cell(0,4, 'Universitas Indonesia', '0', 1, 'L');
			$this->Cell(15);
			$this->Cell(0,4, 'Fakultas Ilmu Sosial dan Ilmu Politik', '0', 1, 'L');
			$this->Cell(15);
			$this->Cell(0,4, $_SESSION["programstudi"], '0', 1, 'L');
			$this->Ln(4);
			$this->SetFont('Arial','B','9');
			$this->Cell(0,3, $_SESSION["judullaporan"], '0', 1, 'C');
			$this->Ln(4);
		}
	//Page footer
		function Footer()
		{
			//Position at 1.5 cm from bottom
			$this->SetY(-15);
			//Arial italic 8
			$this->SetFont('Arial','I',8);
			//Page number
			$this->Cell(0,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'C');
		}

	}

	$pdf = new PDF('L','mm','A4');
	$pdf->AddPage();
	$pdf->AliasNbPages();
	 
	/**************************************\
	 proses pencetakan data dosen
	\**************************************/

	#tampilkan data tabelnya
	$pdf->SetFillColor(215,225,245);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(215,225,245);
	$pdf->SetFont('Arial','B','9');
	$pdf->Cell(277,8,'Data Dosen',0,1,'L',true);

	#Data Dosen
	$pdf->Cell(3);
	$pdf->SetFont('Arial','','9');
	$pdf->Cell(40,8,'NIP/NUP',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $nip, 0, 0, 'L');
	$pdf->Cell(50);
	$pdf->Cell(50,8,'Jumlah Ditransfer',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, number_format($jml_ditransfer), 0, 1, 'L');
	$pdf->Cell(3);
	$pdf->Cell(40,8,'Nama',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $nama_pengajar, 0, 0, 'L');
	$pdf->Cell(50);
	$pdf->Cell(50, 8, 'Nama di Rekening', 0, 0, 'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $nama_rekening, 0, 1, 'L');
	$pdf->Cell(3);
	$pdf->Cell(40,8,'Status Kepegawaian',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $skema, 0, 0, 'L');
	$pdf->Cell(50);
	$pdf->Cell(50, 8, 'Nama Bank', 0, 0, 'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $nama_bank, 0, 1, 'L');
	$pdf->Cell(3);
	$pdf->Cell(40,8,'Jabatan Fungsional',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $jabatan_fungsional, 0, 0, 'L');
	$pdf->Cell(50);
	$pdf->Cell(50, 8, 'Nomor Rekening', 0, 0, 'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $no_rekening, 0, 1, 'L');
	$pdf->Cell(3);
	$pdf->Cell(40, 8, 'Status Perkawinan', 0, 0, 'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $status_nikah, 0, 0, 'L');
	$pdf->Cell(50);
	$pdf->Cell(50, 8, 'NPWP', 0, 0, 'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(50, 8, $npwp, 0, 1, 'L');
	$pdf->Ln(4);

	#Honor dan Tunjangan
	$pdf->SetFont('Arial','B','9');
	$pdf->Cell(277,8,'Honor dan Tunjangan (sesuai ketetapan universitas):',0,1,'L',true);

	#$pdf->SetY(58);
	$pdf->SetFont('Arial','','9');
	$pdf->Cell(3);
	$pdf->Cell(52,8,'Dasar Kesejahteraan Setara BHMN',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($dk_bhmn), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(52,8,'Total Honor Xu',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($xu_skema_inti), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(57,8,'Tunjangan Kesehatan (Inhealth)',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20,8, number_format($ts_kesehatan), 0, 1, 'R');
	$pdf->Cell(3);
	$pdf->Cell(52,8,'Tunjangan Skema Inti Pengajaran',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($ts_inti_pengajaran), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(52,8,'Total Honor Xf Skema Inti',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($xf_skema_inti), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(57,8,'Tunjangan Pajak',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($tj_pajak), 0, 1, 'R');
	$pdf->Cell(3);
	$pdf->Cell(52,8,'Tunjangan Skema Inti Penelitian',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($ts_inti_penelitian), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(52,8,'Total Honor Xf Skema Lain',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($tot_xf_skema_lain), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(57,8,'Honor Bruto',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($honor_bruto), 0, 1, 'R');
	$pdf->Cell(3);
	$pdf->Cell(52,8,'Tunjangan Skema Struktural',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($ts_struktural), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(52,8,'Honor Lainnya',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($honor_bimbingan), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(57,8,'Pajak',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($pajak), 0, 1, 'R');
	$pdf->Cell(3);
	$pdf->Cell(52,8,'Tunjangan SAF/DGBF',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($tj_saf), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(52,8,'Tunda Bayar Bulan Sebelumnya',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($tunda_bayar), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(57,8,'Honor Neto',0,0,'L');
	$pdf->Cell(3,8,' ',0,0,'L');
	$pdf->Cell(20, 8, number_format($honor_neto), 0, 1, 'R');
	$pdf->Cell(3);
	$pdf->Cell(52,8,'Tunjangan Jabatan Struktural',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($tj_jabatan), 0, 0, 'R');
	$pdf->Cell(20);
	$pdf->Cell(52,8,'Kurang/Lebih Bayar',0,0,'L');
	$pdf->Cell(3,8,':',0,0,'L');
	$pdf->Cell(20, 8, number_format($kl_bayar), 0, 0, 'R');

	$pdf->Ln(20);
	$pdf->SetFont('Arial','BUI','8');
	$pdf->Cell(80,5,'Keterangan:',0,1,'L');
	$pdf->SetFont('Arial','','8');
	$pdf->Cell(80,5,'- Nomor Rekening yang dipakai adalah nomor Rekening Fakultas Induk',0,1,'L');
	$pdf->Cell(80,5,'- Maksimal 4 SKS untuk Dosen dengan Skema Struktural',0,1,'L');
	$pdf->Cell(80,5,'- Maksimal 6 SKS untuk Dosen Inti Penelitian',0,1,'L');
	$pdf->Cell(80,5,'- Maksimal 18 SKS untuk Dosen Inti Pengajaran',0,1,'L');
	$pdf->Cell(80,5,'- Maksimal 4 SKS untuk Dosen Skema Lain (Dosen Tidak Tetap/Dosen Luar Biasa/Pensiun)',0,1,'L');
	$pdf->Cell(80,5,'- Pemilihan berdasarkan SKS dengan koefisien tertinggi sampai terendah',0,1,'L');
	$pdf->Cell(80,5,'- Rincian Data Honor Pengajaran Terlampir',0,1,'L');

	#cetak garis
	$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200,200,200));
	$pdf->Line(10, 29.1, 10, 77, $style); //garis vertikal sebelah kiri box data dosen
	$pdf->Line(287, 29.1, 287, 77, $style);  //garis vertikal sebelah kanan box data dosen
	$pdf->Line(10, 77, 287, 77, $style);  //garis horizontal box data dosen
	$pdf->Line(10, 81, 10, 137, $style); //garis vertikal sebelah kiri box honor tunjangan
	$pdf->Line(287, 81, 287, 137, $style);  //garis vertikal kanan box honor tunjangan
	$pdf->Line(10, 137, 287, 137, $style);  //garis horizontal box honor tunjangan

	$pdf->Ln(8);

	/**************************************\
	 proses pencetakan rincian matakuliah
	\**************************************/

	#ambil data ikut hitung = 1
	$query1 = "SELECT programstudi, program, bobotkontribusi, bobotkontribusi/100*sks as sksekivalen, kodemk, namamatakuliah, sks, namakelas, hadiraktual, kehadiranseharusnya, honorxuskemainti, honorxfskemainti + honorxfskemalain + honorxflintasfak as honorxf, totalhonor
				FROM kalban 
				WHERE nip = '$nip' and ikuthitung = 1 and tahun = $tahun and bulan = '$periode_bulan' and kodepdpt=0
				ORDER BY program, programstudi, namamatakuliah, kodekelas";
				
	$sql1 = mysql_query ($query1) or die ("Gagal ngambil data Mata Kuliah ikut hitung 1: ".mysql_error());
	$data1 = array();
	while ($row1 = mysql_fetch_assoc($sql1)) {
		array_push($data1, $row1);
	}

	#hitung sub total ikut hitung = 1
	$subtotalhonorxu1 = 0;
	$subtotalhonorxf1 = 0;
	$subtotalhonor1 = 0;
	$i = 0;
	$rows1 = mysql_num_rows($sql1);

	for ($i; $i<$rows1; $i++) {	
		$subtotalhonorxu1 = $subtotalhonorxu1 + $data1["$i"]["honorxuskemainti"];
		$subtotalhonorxf1 = $subtotalhonorxf1 + $data1["$i"]["honorxf"];
		$subtotalhonor1 = $subtotalhonor1 + $data1["$i"]["totalhonor"];
		$sksEkivalen1 = $sksEkivalen1 + $data1["$i"]["sksekivalen"];
	}

	#ambil data ikut hitung = 0
	$query2 = "SELECT programstudi, program, bobotkontribusi, bobotkontribusi/100*sks as sksekivalen, kodemk, namamatakuliah, sks, namakelas, hadiraktual, kehadiranseharusnya, honorxuskemainti, honorxfskemainti + honorxfskemalain + honorxflintasfak as honorxf, totalhonor
				FROM kalban 
				WHERE nip = '$nip' and ikuthitung = 0 and tahun = $tahun and bulan = '$periode_bulan' and kodepdpt=0
				ORDER BY program, programstudi, namamatakuliah, kodekelas";
				
	$sql2 = mysql_query ($query2) or die ("Gagal ngambil data Mata Kuliah ikut hitung 0: ".mysql_error());
	$data2 = array();
	while ($row2 = mysql_fetch_assoc($sql2)) {
		array_push($data2, $row2);
	}
	 
	#hitung sub total ikut hitung = 0
	$subtotalhonorxu2 = 0;
	$subtotalhonorxf2 = 0;
	$subtotalhonor2 = 0;
	$i = 0;
	$rows2 = mysql_num_rows($sql2);

	for ($i; $i<$rows2; $i++) {	
		$subtotalhonorxu2 = $subtotalhonorxu2 + $data2["$i"]["honorxuskemainti"];
		$subtotalhonorxf2 = $subtotalhonorxf2 + $data2["$i"]["honorxf"];
		$subtotalhonor2 = $subtotalhonor2 + $data2["$i"]["totalhonor"];
		$sksEkivalen2 = $sksEkivalen2 + $data2["$i"]["sksekivalen"];
	}
	 
	#setting judul laporan dan header tabel
	$header = array(
		array("label"=>"Program Studi", "length"=>40, "align"=>"C", "align2"=>"L"),
		array("label"=>"Program", "length"=>17, "align"=>"L", "align2"=>"L"),
		array("label"=>"Bobot Kontribusi", "length"=>15, "align"=>"L", "align2"=>"C"),
		array("label"=>"SKS Ekivalen", "length"=>13, "align"=>"C", "align2"=>"C"),
		array("label"=>"Kode Mata Kuliah", "length"=>15, "align"=>"C", "align2"=>"C"),
		array("label"=>"Nama Mata Kuliah", "length"=>62, "align"=>"C", "align2"=>"L"),
		array("label"=>"SKS", "length"=>8, "align"=>"C", "align2"=>"C"),
		array("label"=>"Nama Kelas", "length"=>32, "align"=>"C", "align2"=>"L"),
		array("label"=>"Hadir Aktual;", "length"=>9, "align"=>"C", "align2"=>"C"),
		array("label"=>"Wajib Hadir", "length"=>9, "align"=>"C", "align2"=>"C"),
		array("label"=>"Honor Xu", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Honor Xf", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Total Honor", "length"=>20, "align"=>"C", "align2"=>"R")
	);

	#buat header tabel ikut hitung = 1
	$pdf->SetFont('Arial','I','8');
	$pdf->Cell(0,4, 'Rincian Data Honor Pengajaran Sesuai Ketetapan Universitas', '0', 1, 'L');	
	$pdf->SetFont('Arial','B','8');
	$pdf->SetFillColor(215,225,245);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(215,225,245);

	$pdf->Cell(40,4, '', 1, 0, 'C', true);		
	$pdf->Cell(17,4, '', 1, 0, 'C', true);		
	$pdf->Cell(15,4, 'Bobot', 1, 0, 'C', true);		
	$pdf->Cell(13,4, 'SKS', 1, 0, 'C', true);		
	$pdf->Cell(15,4, '', 1, 0, 'C', true);		
	$pdf->Cell(62,4, '', 1, 0, 'C', true);		
	$pdf->Cell(8,4, '', 1, 0, 'C', true);		
	$pdf->Cell(32,4, '', 1, 0, 'C', true);		
	$pdf->Cell(9,4, 'Jml', 1, 0, 'C', true);		
	$pdf->Cell(9,4, 'Wajib', 1, 0, 'C', true);		
	$pdf->Cell(20,4, 'Honor', 1, 0, 'C', true);		
	$pdf->Cell(20,4, 'Honor', 1, 0, 'C', true);		
	$pdf->Cell(20,4, 'Total', 1, 1, 'C', true);	

	$pdf->Cell(40,4, 'Program Studi', 1, 0, 'C', true);
	$pdf->Cell(17,4, 'Jenjang', 1, 0, 'C', true);
	$pdf->Cell(15,4, 'Kontribusi', 1, 0, 'C', true);
	$pdf->Cell(13,4, 'Ekivalen', 1, 0, 'C', true);
	$pdf->Cell(15,4, 'Kode MK', 1, 0, 'C', true);
	$pdf->Cell(62,4, 'Nama Mata Kuliah', 1, 0, 'C', true);
	$pdf->Cell(8,4, 'SKS', 1, 0, 'C', true);
	$pdf->Cell(32,4, 'Kelas', 1, 0, 'C', true);
	$pdf->Cell(9,4, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(9,4, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(20,4, 'Xu', 1, 0, 'C', true);
	$pdf->Cell(20,4, 'Xf', 1, 0, 'C', true);
	$pdf->Cell(20,4, 'Honor', 1, 1, 'C', true);

	#tampilkan data rincian mata kuliah
	$pdf->SetFillColor(238,249,269);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(221,232,252);
	$pdf->SetFont('Arial','','8');
	$fill = false;

	#tampilkan data ikut hitung = 1
	foreach ($data1 as $baris1) {
		$i = 0;
		$t = 15;
		foreach ($baris1 as $cell1) {
			if ($i == 10 or $i == 11 or $i == 12){ //format honor
					$cell1 = number_format($cell1);
				} else if ($i == 3){
					$cell1 = number_format($cell1,"2"); //format sks ekivalen	
				} else {
					$cell1 = $cell1;
				}
				
			$pdf->Cell($header[$i]['length'], 4, $cell1, 1, '0', $header[$i]['align2'], $fill);
			$i++;
		}	
		$fill = !$fill;
		$pdf->Ln();
		$t=+8;
	}
	
	//tampilkan total ikut hitung = 1
	$pdf->Ln(1);
	$pdf->SetFillColor(238,249,269);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(221,232,252);
	$pdf->SetFont('Arial','B','8');
	$pdf->cell(72); //220
	$pdf->cell(13,4,number_format($sksEkivalen1,"2"),1,0,'C',true);
	$pdf->cell(135);
	$pdf->cell(20,4,number_format($subtotalhonorxu1),1,0,'R',true);
	$pdf->cell(20,4,number_format($subtotalhonorxf1),1,0,'R',true);
	$pdf->cell(20,4,number_format($subtotalhonor1),1,0,'R',true);
	$pdf->Ln(8);

	#buat header tabel ikut hitung = 0
	if ($rows2 > 0){
		$pdf->SetFont('Arial','I','8');
		$pdf->Cell(0,4, 'Rincian Data Honor Pengajaran dengan Ikut Hitung = 0 (Sesuai Kebijakan Universitas Tidak Terbayarkan)', '0', 1, 'L');	

		$pdf->SetFont('Arial','B','8');
		$pdf->SetFillColor(215,225,245);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(215,225,245);

		$pdf->Cell(40,4, '', 1, 0, 'C', true);		
		$pdf->Cell(17,4, '', 1, 0, 'C', true);		
		$pdf->Cell(15,4, 'Bobot', 1, 0, 'C', true);		
		$pdf->Cell(13,4, 'SKS', 1, 0, 'C', true);		
		$pdf->Cell(15,4, '', 1, 0, 'C', true);		
		$pdf->Cell(62,4, '', 1, 0, 'C', true);		
		$pdf->Cell(8,4, '', 1, 0, 'C', true);		
		$pdf->Cell(32,4, '', 1, 0, 'C', true);		
		$pdf->Cell(9,4, 'Jml', 1, 0, 'C', true);		
		$pdf->Cell(9,4, 'Wajib', 1, 0, 'C', true);		
		$pdf->Cell(20,4, 'Honor', 1, 0, 'C', true);		
		$pdf->Cell(20,4, 'Honor', 1, 0, 'C', true);		
		$pdf->Cell(20,4, 'Total', 1, 1, 'C', true);	

		$pdf->Cell(40,4, 'Program Studi', 1, 0, 'C', true);
		$pdf->Cell(17,4, 'Jenjang', 1, 0, 'C', true);
		$pdf->Cell(15,4, 'Kontribusi', 1, 0, 'C', true);
		$pdf->Cell(13,4, 'Ekivalen', 1, 0, 'C', true);
		$pdf->Cell(15,4, 'Kode MK', 1, 0, 'C', true);
		$pdf->Cell(62,4, 'Nama Mata Kuliah', 1, 0, 'C', true);
		$pdf->Cell(8,4, 'SKS', 1, 0, 'C', true);
		$pdf->Cell(32,4, 'Kelas', 1, 0, 'C', true);
		$pdf->Cell(9,4, 'Hadir', 1, 0, 'C', true);
		$pdf->Cell(9,4, 'Hadir', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Xu', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Xf', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Honor', 1, 1, 'C', true);


		#tampilkan data tabelnya
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','','8');
		$fill = false;
				
		#tampilkan data ikut hitung = 0
		foreach ($data2 as $baris2) {
			$i = 0;
			foreach ($baris2 as $cell2) {
				if ($i == 10 or $i == 11 or $i == 12){ //format honor
					$cell2 = number_format($cell2);
				} else if ($i == 3){
					$cell2 = number_format($cell2,"2"); //format sks ekivalen
				} else {
					$cell2 = $cell2;
				}

				$pdf->Cell($header[$i]['length'], 4, $cell2, 1, '0', $header[$i]['align2'], $fill);
				$i++;
			}	
			$fill = !$fill;
			$t=+8;
			$pdf->Ln();
		}

		$pdf->Ln(1);
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','B','8');
		$pdf->cell(72); //220
		$pdf->cell(13,4,number_format($sksEkivalen2,"2"),1,0,'C',true);
		$pdf->cell(135);
		$pdf->cell(20,4,number_format($subtotalhonorxu2),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonorxf2),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonor2),1,0,'R',true);
		$pdf->Ln($t);
	/*
		#Keterangan Rincian Pembayaran
		$subtotalhonorxu = $subtotalhonorxu1 + $subtotalhonorxu2;
		$subtotalhonorxf = $subtotalhonorxf1 + $subtotalhonorxf2;
		$subtotalhonor = $subtotalhonor1 + $subtotalhonor2;
		
		$pdf->Ln(4);
		$pdf->cell(173);
		$pdf->cell(47,4, 'Rincian Pembayaran : ', '0', 0, 'L');
		$pdf->SetFont('Arial','B','8');
		$pdf->SetFillColor(215,225,245);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(215,225,245);
		$pdf->Cell(20,4, 'Honor', 1, 0, 'C', true);		
		$pdf->Cell(20,4, 'Honor', 1, 0, 'C', true);		
		$pdf->Cell(20,4, 'Total', 1, 1, 'C', true);	
		$pdf->cell(220);
		$pdf->Cell(20,4, 'Xu', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Xf', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Honor', 1, 1, 'C', true);
		$pdf->Ln(1);
		
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','B','8');
		$pdf->cell(173);
		$pdf->cell(47,4, 'Sesuai Ketetapan Universitas  = ', '0', 0, 'L');
		$pdf->cell(20,4,number_format($subtotalhonorxu1),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonorxf1),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonor1),1,1,'R',true);	
		$pdf->Ln(1);
		$pdf->cell(173);
		$pdf->cell(47,4, 'Sesuai Kebijakan Fakultas       = ', '0', 0, 'L');
		$pdf->cell(20,4,number_format($subtotalhonorxu2),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonorxf2),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonor2),1,1,'R',true);
		$pdf->Ln(1);
		$pdf->cell(173);
		$pdf->cell(47,4, 'Total Pembayaran                     = ', '0', 0, 'L');
		$pdf->cell(20,4,number_format($subtotalhonorxu),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonorxf),1,0,'R',true);
		$pdf->cell(20,4,number_format($subtotalhonor),1,1,'R',true);
		*/
	}


	/**************************************\
	 proses pencetakan rincian bimbingan
	\**************************************/

	$data = "";
	$data = array();
	$query = "	SELECT departemen, program, jenis_bimbingan, honor
				FROM bimbingan a, organisasi b
				WHERE tahun = $tahun and bulan = $periode_bulan and a.nip = '$nip' and kodeorganisasi = kd_organisasi";
	$sql = mysql_query ($query) or die ("error data bimbingan: ".mysql_error());
	$rows = mysql_num_rows($sql);

	if ($rows > 0){
		
		$pdf->Ln(4);
		
		#setting judul laporan dan header tabel
		$header = array(
			array("label"=>"Departemen", "length"=>40, "align"=>"C", "align2"=>"L"),
			array("label"=>"Jenjang", "length"=>30, "align"=>"C", "align2"=>"L"),
			array("label"=>"Nama Bimbingan", "length"=>90, "align"=>"C", "align2"=>"L"),
			array("label"=>"Total Honor", "length"=>20, "align"=>"C", "align2"=>"R")
		);

		#buat header tabel
		$pdf->SetFont('Arial','I','8');
		$pdf->Cell(0,4, 'Rincian Honor Lainnya', '0', 1, 'L');	
		$pdf->SetFont('Arial','B','8');
		$pdf->SetFillColor(215,225,245);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(215,225,245);

		$pdf->Cell(40,4, 'Program Studi', 1, 0, 'C', true);
		$pdf->Cell(30,4, 'Jenjang', 1, 0, 'C', true);
		$pdf->Cell(90,4, 'Keterangan', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Honor', 1, 1, 'C', true);

		#tampilkan data bimbingan
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','','8');
		$fill = false;

		while ($row = mysql_fetch_assoc($sql)) {
			array_push($data, $row);
		}
		#tampilkan data tabelnya
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','','8');
		$fill = false;
				
		#tampilkan data bimbingan
		$honor = 0;
		foreach ($data as $baris) {
			$i = 0;
			foreach ($baris as $cell) {
				if ($i == 3){ //format honor
					$cellx = number_format($cell);
					$honor = $honor + $cell;
				} else {
					$cellx = $cell;
				}
				$pdf->Cell($header[$i]['length'], 4, $cellx, 1, '0', $header[$i]['align2'], $fill);
				$i++;
			}	
			$fill = !$fill;
			$t=+8;
			$pdf->Ln();
		}
		
		#tampilkan total honor bimbingan
		$pdf->Ln(1);
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','B','8');
		
		$pdf->cell(160);
		$pdf->cell(20,4,number_format($honor),1,0,'R',true);
		$pdf->Ln();
	}

	/**************************************\
	 proses pencetakan rincian insentif (di disable)
	\**************************************/

	$data = "";
	$data = array();
	$query = "	SELECT departemen, program, jenis_bimbingan, honor
				FROM bimbingan a, organisasi b
				WHERE tahun = $tahun and bulan = $periode_bulan and a.nip = '$nip' and kodeorganisasi = kd_organisasi and flag = 1";
	$sql = mysql_query ($query) or die ("error data bimbingan/insentif: ".mysql_error());
	$rows = mysql_num_rows($sql);

	if ($rows > 0){
		$pdf->Ln(4);
		#setting judul laporan dan header tabel
		$header = array(
			array("label"=>"Departemen", "length"=>40, "align"=>"C", "align2"=>"L"),
			array("label"=>"Jenjang", "length"=>30, "align"=>"C", "align2"=>"L"),
			array("label"=>"Nama Bimbingan", "length"=>70, "align"=>"C", "align2"=>"L"),
			array("label"=>"Total Honor", "length"=>20, "align"=>"C", "align2"=>"R")
		);
		
		#buat header tabel
		$pdf->SetFont('Arial','I','8');
		$pdf->Cell(0,4, 'Rincian Honor Insentif', '0', 1, 'L');	
		$pdf->SetFont('Arial','B','8');
		$pdf->SetFillColor(215,225,245);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(215,225,245);

		$pdf->Cell(40,4, 'Program Studi', 1, 0, 'C', true);
		$pdf->Cell(30,4, 'Jenjang', 1, 0, 'C', true);
		$pdf->Cell(70,4, 'Keterangan', 1, 0, 'C', true);
		$pdf->Cell(20,4, 'Honor', 1, 1, 'C', true);

		#tampilkan data insentif
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','','8');
		$fill = false;

		while ($row = mysql_fetch_assoc($sql)) {
			array_push($data, $row);
		}
		#tampilkan data tabelnya
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','','8');
		$fill = false;
				
		#tampilkan data insentif
		$honor = 0;
		foreach ($data as $baris) {
			$i = 0;
			foreach ($baris as $cell) {
				if ($i == 3){ //format honor
					$cellx = number_format($cell);
					$honor = $honor + $cell;
				} else {
					$cellx = $cell;
				}
				$pdf->Cell($header[$i]['length'], 4, $cellx, 1, '0', $header[$i]['align2'], $fill);
				$i++;
			}	
			$fill = !$fill;
			$t=+8;
			$pdf->Ln();
		}
		
		#tampilkan total honor insentif
		$pdf->Ln(1);
		$pdf->SetFillColor(238,249,269);
		$pdf->SetTextColor(0);
		$pdf->SetDrawColor(221,232,252);
		$pdf->SetFont('Arial','B','8');
		
		$pdf->cell(140);
		$pdf->cell(20,4,number_format($honor),1,0,'R',true);
		$pdf->Ln();
	}

	#output file PDF
	$pdf->Output();
}
?>
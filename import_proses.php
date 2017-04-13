<?php
// menggunakan class phpExcelReader
include("excel_reader2.php");

// koneksi ke mysql
include("conn.php");
include("import_interface.php");

//inisialisasi
$tahun = $_POST["tahun"];
$bulan = $_POST["bulan"];
$Kode = 1;
$data_gagal = "";
$data_gagal = array();

if ($bulan == "Februari" or $bulan == "Maret" or $bulan == "April" or $bulan == "Mei" or $bulan == "Juni"){
	$tahun_akad = $tahun - 1;
	$Semester = 2;
} else if ($bulan == "Januari"){
	$tahun_akad = $tahun - 1;
	$Semester = 1;
} else {
	$tahun_akad = $tahun;
	$Semester = 1;
};

$FlagTampil = 1;
$FlagAep = 0;

switch($bulan)
{
	case "Januari":
		$vbulan = "01";
		break;
	case "Februari":
		$vbulan = "02";
		break;
	case "Maret":
		$vbulan = "03";
		break;
	case "April":
		$vbulan = "04";
		break;
	case "Mei":
		$vbulan = "05";
		break;
	case "Juni":
		$vbulan = "06";
		break;
	case "Juli":
		$vbulan = "07";
		break;
	case "Agustus":
		$vbulan = "08";
		break;
	case "September":
		$vbulan = "09";
		break;
	case "Oktober":
		$vbulan = "10";
		break;
	case "November":
		$vbulan = "11";
		break;
	case "Desember":
		$vbulan = "12";
		break;
}

// membaca file excel yang diupload
$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

// membaca jumlah baris dari data excel
$baris = $data->rowcount($sheet_index=0);

// nilai awal counter untuk jumlah data yang sukses dan yang gagal diimport
$sukses = 0;
$gagal = 0;
$j = 0;

//box
echo "
<br>
<div class='inset' text-align:center;>
	<b class='b1'></b><b class='b2'></b><b class='b3'></b><b class='b4'></b>
		<div class='boxcontent' text-align:center;>
			<div style='font-family:arial; font-size:10px; font-weight:bold; text-align:center; color:#555545;'>
				<p style='text-align:center;'>
					<label>Log Import</label><br>					
";

// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for ($i=2; $i<=$baris; $i++)
{
	// membaca data
	/*field lama
	$No = $data->val($i,1);
	$Id = $data->val($i,2);
	$Nip = $data->val($i,3);
	$NamaPengajar = addslashes($data->val($i,4));
	$IndukFakultas = $data->val($i,5);
	$JabatanFungsional = $data->val($i,6);
	$Skema = $data->val($i,7);
	$BobotKontribusi = $data->val($i,8);
	$SKSEkivalen = $data->val($i,9);
	$TotSKSsiak = $data->val($i,10);
	$TotSKSOK = $data->val($i,11);
	$UnitFakultas = $data->val($i,12);
	$KodeOrganisasi = $data->val($i,13);
	$ProgramStudi = $data->val($i,14);
	$Jenjang = $data->val($i,15);
	$Program = $data->val($i,16);
	$KategoriKoefisien = $data->val($i,17);
	$NoSK = $data->val($i,18);
	$KodeMK = $data->val($i,19);
	$KodePDPT = $data->val($i,20);
	$NamaMataKuliah = $data->val($i,22);
	$SKS = $data->val($i,23);
	$JenisMataKuliah = $data->val($i,24);
	$UntukSms = $data->val($i,25);
	$Ditawarkan = $data->val($i,26);
	$KodeKelas = $data->val($i,27);
	$NamaKelas = $data->val($i,28);
	$JenisKelas = $data->val($i,29);
	$NipPJkelas = $data->val($i,30);
	$PengantarBhsAsing = $data->val($i,31);
	$HadirAktual = $data->val($i,32);
	$KehadiranSeharusnya = $data->val($i,33);
	$SatuanKehadiran = $data->val($i,34);
	$HadirAktualAsing = $data->val($i,35);
	$KehadiranSeharusnyaAsing = $data->val($i,36);
	$SatuanHadirAsing = $data->val($i,37);
	$PersenKehadiran = $data->val($i,38);
	$PersenKehadiranAsing = $data->val($i,39);
	$IndexXu = $data->val($i,40);
	$IndexXfPDPT = $data->val($i,41);
	$XfSkemaLainLuar = $data->val($i,42);
	$IndexXfallFakultas = $data->val($i,43);
	$IndexXfall = $data->val($i,44);
	$HonorXuSkemaInti = $data->val($i,45);
	$HonorXfSkemaInti = $data->val($i,46);
	$HonorXfSkemaLain = $data->val($i,47);
	$HonorXfLintasFak = $data->val($i,48);
	$HonorPDPT = $data->val($i,49);
	$HonorBhsAsing = $data->val($i,51);
	$TotalHonorFak = $data->val($i,52);
	$TotalHonor = $data->val($i,53);
	$LintasFak = $data->val($i,54);
	$IkutHitung = $data->val($i,55);
	$KodePasca = $data->val($i,56);
	$SiakIdentifier = $data->val($i,57);
	*/

	//field baru kalban
	$No = $data->val($i,1);
	$Id = $data->val($i,2);
	$Nip = $data->val($i,3);
	$NamaPengajar = addslashes($data->val($i,4));
	$IndukFakultas = $data->val($i,6);
	$JabatanFungsional = $data->val($i,7);
	$Skema = $data->val($i,8);
	$BobotKontribusi = $data->val($i,9);
	$SKSEkivalen = $data->val($i,10);
	$TotSKSsiak = $data->val($i,17);
	$TotSKSOK = $data->val($i,18);
	$UnitFakultas = $data->val($i,5);
	$KodeOrganisasi = $data->val($i,19);
	$ProgramStudi = $data->val($i,20);
	$Jenjang = $data->val($i,21);
	$Program = $data->val($i,22);
	$KategoriKoefisien = $data->val($i,23);
	$NoSK = $data->val($i,24);
	$KodeMK = $data->val($i,25);
	$KodePDPT = $data->val($i,26);
	$NamaMataKuliah = $data->val($i,28);
	$SKS = $data->val($i,29);
	$JenisMataKuliah = $data->val($i,30);
	$UntukSms = $data->val($i,31);
	$Ditawarkan = $data->val($i,32);
	$KodeKelas = $data->val($i,33);
	$NamaKelas = $data->val($i,34);
	$JenisKelas = $data->val($i,35);
	$NipPJkelas = $data->val($i,36);
	$PengantarBhsAsing = $data->val($i,37);
	$HadirAktual = $data->val($i,38);
	$KehadiranSeharusnya = $data->val($i,39);
	//$SatuanKehadiran = $data->val($i,34);
	$HadirAktualAsing = $data->val($i,40);
	$KehadiranSeharusnyaAsing = $data->val($i,41);
	//$SatuanHadirAsing = $data->val($i,37);
	$PersenKehadiran = $data->val($i,42);
	$PersenKehadiranAsing = $data->val($i,43);
	$IndexXu = $data->val($i,44);
	$IndexXfPDPT = $data->val($i,45);
	$XfSkemaLainLuar = $data->val($i,46);
	$IndexXfallFakultas = $data->val($i,47);
	$IndexXfall = $data->val($i,48);
	$HonorXuSkemaInti = $data->val($i,49);
	$HonorXfSkemaInti = $data->val($i,50);
	$HonorXfSkemaLain = $data->val($i,51);
	$HonorXfLintasFak = $data->val($i,52);
	$HonorPDPT = $data->val($i,53);
	$HonorBhsAsing = $data->val($i,55);
	$TotalHonorFak = $data->val($i,56);
	$TotalHonor = $data->val($i,57);
	$LintasFak = $data->val($i,58);
	$IkutHitung = $data->val($i,59);
	$KodePasca = $data->val($i,60);
	//$SiakIdentifier = $data->val($i,57);


	if(empty($PengantarBhsAsing)) $PengantarBhsAsing = 0;
	if(empty($HadirAktual)) $HadirAktual = 0;
	if(empty($KehadiranSeharusnya)) $KehadiranSeharusnya = 0;
	if(empty($HadirAktualAsing)) $HadirAktualAsing = 0;
	if(empty($KehadiranSeharusnyaAsing)) $KehadiranSeharusnyaAsing = 0;
	if(empty($HonorXuSkemaInti)) $HonorXuSkemaInti = 0;
	if(empty($HonorXfSkemaInti)) $HonorXfSkemaInti = 0;
	if(empty($HonorXfSkemaLain)) $HonorXfSkemaLain = 0;
	if(empty($HonorXfLintasFak)) $HonorXfLintasFak = 0;
	if(empty($HonorPDPT)) $HonorPDPT = 0;
	if(empty($HonorBhsAsing)) $HonorBhsAsing = 0;
	if(empty($TotalHonorFak)) $TotalHonorFak = 0;
	if(empty($TotalHonor)) $TotalHonor = 0;
	if(empty($LintasFak)) $LintasFak = 0;
	if(empty($IkutHitung)) $IkutHitung = 0;	
	
  // setelah data dibaca, sisipkan ke dalam tabel kalban
  $query = "INSERT INTO kalban (
				tahun_akad,
				tahun,
				bulan,
				No,
				Id,
				Nip,
				NamaPengajar,
				JabatanFungsional,
				Skema,
				BobotKontribusi,
				SKSEkivalen,
				KodeOrganisasi,
				ProgramStudi,
				Jenjang,
				Program,
				KategoriKoefisien,
				KodeMK,
				KodePDPT,
				NamaMataKuliah,
				SKS,
				KodeKelas,
				NamaKelas,
				PengantarBhsAsing,
				HadirAktual,
				KehadiranSeharusnya,
				SatuanKehadiran,
				KehadiranAktualAsing,
				KehadiranSeharusnyaAsing,
				SatuanHadirAsing,
				HonorXuSkemaInti,
				HonorXfSkemaInti,
				HonorXfSkemaLain,
				HonorXfLintasFak,
				HonorPDPT,
				HonorBhsAsing,
				TotalHonorFak,
				TotalHonor,
				LintasFak,
				IkutHitung,
				KodePasca,
				SiakIdentifier,
				Kode,
				Semester,
				FlagTampil,
				FlagAep
				) 
			VALUES (
				$tahun_akad,
				$tahun,
				'$vbulan',
				$No,
				$Id,
				'$Nip',
				'$NamaPengajar',
				'$JabatanFungsional',
				'$Skema',
				$BobotKontribusi,
				$SKSEkivalen,
				'$KodeOrganisasi',
				'$ProgramStudi',
				'$Jenjang',
				'$Program',
				'$KategoriKoefisien',
				'$KodeMK',
				$KodePDPT,
				'$NamaMataKuliah',
				$SKS,
				$KodeKelas,
				'$NamaKelas',
				$PengantarBhsAsing,
				$HadirAktual,
				$KehadiranSeharusnya,
				'$SatuanKehadiran',
				$HadirAktualAsing,
				$KehadiranSeharusnyaAsing,
				'$SatuanHadirAsing',
				$HonorXuSkemaInti,
				$HonorXfSkemaInti,
				$HonorXfSkemaLain,
				$HonorXfLintasFak,
				$HonorPDPT,
				$HonorBhsAsing,
				$TotalHonorFak,
				$TotalHonor,
				$LintasFak,
				$IkutHitung,
				'$KodePasca',
				'$SiakIdentifier',
				concat('$Nip',$KodeKelas),
				$Semester,
				$FlagTampil,
				$FlagAep)";
				
  $hasil = mysql_query($query);

  // jika proses insert data sukses, maka counter $sukses bertambah
  // jika gagal, maka counter $gagal yang bertambah
  if ($hasil){
	$sukses++;
  } else {
	$gagal++;
	echo "<div style='padding-left:10px; vertical-align:middle; font: 11px verdana; border-top:1px solid orange;'>
			<span style='color:blue'>ID = ".$Id." -> </span>
			<span style='color:red'>gagal </span>
			<span></span>
		  </div>";
  }
}

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

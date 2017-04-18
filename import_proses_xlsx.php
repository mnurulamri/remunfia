<?php
// menggunakan class phpExcelReader
include("excel_reader2.php");

// koneksi ke mysql
//include("conn.php");
//include("import_interface.php");

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

//hapus recor lama
$sql = "DELETE FROM kalban WHERE tahun = '$tahun' AND bulan = '$vbulan'";
mysql_query($sql) or die(mysql_error());

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
echo'<table>';
// import data excel mulai baris ke-2 (karena baris pertama adalah nama kolom)
for($i=1; $i<sizeof($excel); $i++){
	// membaca data
	/* field lama 
	$No =  $excel[$i][0];
	$Id =  $excel[$i][1];
	$Nip =  $excel[$i][2];
	$NamaPengajar =  $excel[$i][3];
	$IndukFakultas =  $excel[$i][4];
	$JabatanFungsional =  $excel[$i][5];
	$Skema =  $excel[$i][6];
	$BobotKontribusi =  $excel[$i][7];
	$SKSEkivalen =  $excel[$i][8];
	$TotSKSsiak =  $excel[$i][9];
	$TotSKSOK =  $excel[$i][10];
	$UnitFakultas =  $excel[$i][11];
	$KodeOrganisasi =  $excel[$i][12];
	$ProgramStudi =  $excel[$i][13];
	$Jenjang =  $excel[$i][14];
	$Program =  $excel[$i][15];
	$KategoriKoefisien =  $excel[$i][16];
	$NoSK =  $excel[$i][17];
	$KodeMK =  $excel[$i][18];
	$KodePDPT =  $excel[$i][19];
	$kodeRIK=  $excel[$i][20];
	$NamaMataKuliah =  $excel[$i][21];
	$SKS =  $excel[$i][22];
	$JenisMataKuliah =  $excel[$i][23];
	$UntukSms =  $excel[$i][24];
	$Ditawarkan =  $excel[$i][25];
	$KodeKelas =  $excel[$i][26];
	$NamaKelas =  $excel[$i][27];
	$JenisKelas =  $excel[$i][28];
	$NipPJkelas =  $excel[$i][29];
	$PengantarBhsAsing =  $excel[$i][30];
	$HadirAktual =  $excel[$i][31];
	$KehadiranSeharusnya =  $excel[$i][32];
	$SatuanKehadiran =  $excel[$i][33];
	$HadirAktualAsing =  $excel[$i][34];
	$KehadiranSeharusnyaAsing =  $excel[$i][35];
	$SatuanHadirAsing =  $excel[$i][36];
	$PersenKehadiran =  $excel[$i][37];
	$PersenKehadiranAsing =  $excel[$i][38];
	$IndexXu =  $excel[$i][39];
	$IndexXfPDPT =  $excel[$i][40];
	$XfSkemaLainLuar =  $excel[$i][41];
	$IndexXfallFakultas =  $excel[$i][42];
	$IndexXfall =  $excel[$i][43];
	$HonorXuSkemaInti =  $excel[$i][44];
	$HonorXfSkemaInti =  $excel[$i][45];
	$HonorXfSkemaLain =  $excel[$i][46];
	$HonorXfLintasFak =  $excel[$i][47];
	$HonorPDPT =  $excel[$i][48];
	$HonorRIK=  $excel[$i][49];
	$HonorBhsAsing =  $excel[$i][50];
	$TotalHonorFak =  $excel[$i][51];
	$TotalHonor =  $excel[$i][52];
	$LintasFak =  $excel[$i][53];
	$IkutHitung =  $excel[$i][54];
	$KodePasca =  $excel[$i][55];
	//$SiakIdentifier = $excel[$i][56];
	*/

	//field baru kalban
	$No =  $excel[$i][0];
	$Id =  $excel[$i][1];
	$Nip =  $excel[$i][2];
	$NamaPengajar =  $excel[$i][3];
	$IndukFakultas =  $excel[$i][5];
	$JabatanFungsional =  $excel[$i][6];
	$Skema =  $excel[$i][7];
	$BobotKontribusi =  $excel[$i][8];
	$SKSEkivalen =  $excel[$i][9];
	$SKSDisetujui =  $excel[$i][10];
	$TotSKSsiak =  $excel[$i][16];
	$TotSKSOK =  $excel[$i][17];
	$UnitFakultas =  $excel[$i][17];
	$KodeOrganisasi =  $excel[$i][18];
	$ProgramStudi =  $excel[$i][19];
	$Jenjang =  $excel[$i][20];
	$Program =  $excel[$i][21];
	$KategoriKoefisien =  $excel[$i][22];
	$NoSK =  $excel[$i][23];
	$KodeMK =  $excel[$i][24];
	$KodePDPT =  $excel[$i][25];
	$kodeRIK=  $excel[$i][26];
	$NamaMataKuliah =  $excel[$i][27];
	$SKS =  $excel[$i][28];
	$JenisMataKuliah =  $excel[$i][29];
	$UntukSms =  $excel[$i][30];
	$Ditawarkan =  $excel[$i][31];
	$KodeKelas =  $excel[$i][32];
	$NamaKelas =  $excel[$i][33];
	$JenisKelas =  $excel[$i][34];
	$NipPJkelas =  $excel[$i][35];
	$PengantarBhsAsing =  $excel[$i][36];
	$HadirAktual =  $excel[$i][37];
	$KehadiranSeharusnya =  $excel[$i][38];
	//$SatuanKehadiran =  $excel[$i][33];
	$HadirAktualAsing =  $excel[$i][39];
	$KehadiranSeharusnyaAsing =  $excel[$i][40];
	//$SatuanHadirAsing =  $excel[$i][36];
	$PersenKehadiran =  $excel[$i][41];
	$PersenKehadiranAsing =  $excel[$i][42];
	$IndexXu =  $excel[$i][43];
	$IndexXfPDPT =  $excel[$i][44];
	$XfSkemaLainLuar =  $excel[$i][45];
	$IndexXfallFakultas =  $excel[$i][46];
	$IndexXfall =  $excel[$i][47];
	$HonorXuSkemaInti =  $excel[$i][48];
	$HonorXfSkemaInti =  $excel[$i][49];
	$HonorXfSkemaLain =  $excel[$i][50];
	$HonorXfLintasFak =  $excel[$i][51];
	$HonorPDPT =  $excel[$i][52];
	$HonorRIK=  $excel[$i][53];
	$HonorBhsAsing =  $excel[$i][54];
	$TotalHonorFak =  $excel[$i][55];
	$TotalHonor =  $excel[$i][56];
	$LintasFak =  $excel[$i][57];
	$IkutHitung =  $excel[$i][58];
	$KodePasca =  $excel[$i][59];
	
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

	/*echo '
	<tr><td>'.$tahun_akad.'</td>
	<td>'.$tahun.'</td>
	<td>'.$vbulan.'</td>
	<td>'.$No.'</td>
	<td>'.$Id.'</td>
	<td>'.$Nip.'</td>
	<td>'.$NamaPengajar.'</td>
	<td>'.$JabatanFungsional.'</td>
	<td>'.$Skema.'</td>
	<td>'.$BobotKontribusi.'</td>
	<td>'.$SKSEkivalen.'</td>
	<td>'.$KodeOrganisasi.'</td>
	<td>'.$ProgramStudi.'</td>
	<td>'.$Jenjang.'</td>
	<td>'.$Program.'</td>
	<td>'.$KategoriKoefisien.'</td>
	<td>'.$KodeMK.'</td>
	<td>'.$KodePDPT.'</td>
	<td>'.$NamaMataKuliah.'</td>
	<td>'.$SKS.'</td>
	<td>'.$KodeKelas.'</td>
	<td>'.$NamaKelas.'</td>
	<td>'.$PengantarBhsAsing.'</td>
	<td>'.$HadirAktual.'</td>
	<td>'.$KehadiranSeharusnya.'</td>
	<td>'.$SatuanKehadiran.'</td>
	<td>'.$HadirAktualAsing.'</td>
	<td>'.$KehadiranSeharusnyaAsing.'</td>
	<td>'.$SatuanHadirAsing.'</td>
	<td>'.$HonorXuSkemaInti.'</td>
	<td>'.$HonorXfSkemaInti.'</td>
	<td>'.$HonorXfSkemaLain.'</td>
	<td>'.$HonorXfLintasFak.'</td>
	<td>'.$HonorPDPT.'</td>
	<td>'.$HonorBhsAsing.'</td>
	<td>'.$TotalHonorFak.'</td>
	<td>'.$TotalHonor.'</td>
	<td>'.$LintasFak.'</td>
	<td>'.$IkutHitung.'</td>
	<td>'.$KodePasca.'</td>

	<td>'.$Nip.$KodeKelas.'</td>
	<td>'.$Semester.'</td>
	<td>'.$FlagTampil.'</td>
	<td>'.$FlagAep.'</td>
	<td>'.$HonorXfSkemaLain .'</td>
	<td>'.$HonorXfLintasFak .'</td>
	<td>'.$HonorPDPT .'</td>
	<td>'.$HonorBhsAsing .'</td>
	<td>'.$TotalHonorFak .'</td>
	<td>'.$TotalHonor .'</td>
	<td>'.$LintasFak .'</td>
	<td>'.$IkutHitung .'</td>
	<td>'.$KodePasca .'</td>
	</tr>'; */
	
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
				SKSDisetujui,
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
				
				Kode,
				Semester,
				FlagTampil,
				FlagAep
				) 
			VALUES (
				'$tahun_akad',
				'$tahun',
				'$vbulan',
				'$No',
				'$Id',
				'$Nip',
				'$NamaPengajar',
				'$JabatanFungsional',
				'$Skema',
				'$BobotKontribusi',
				'$SKSEkivalen',
				'$SKSDisetujui',
				'$KodeOrganisasi',
				'$ProgramStudi',
				'$Jenjang',
				'$Program',
				'$KategoriKoefisien',
				'$KodeMK',
				'$KodePDPT',
				'$NamaMataKuliah',
				'$SKS',
				'$KodeKelas',
				'$NamaKelas',
				'$PengantarBhsAsing',
				'$HadirAktual',
				'$KehadiranSeharusnya',
				
				'$HadirAktualAsing',
				'$KehadiranSeharusnyaAsing',
				
				'$HonorXuSkemaInti',
				'$HonorXfSkemaInti',
				'$HonorXfSkemaLain',
				'$HonorXfLintasFak',
				'$HonorPDPT',
				'$HonorBhsAsing',
				'$TotalHonorFak',
				'$TotalHonor',
				'$LintasFak',
				'$IkutHitung',
				'$KodePasca',
				
				concat('$Nip','$KodeKelas'),
				'$Semester',
				'$FlagTampil',
				'$FlagAep')";
				
  $hasil = mysql_query($query) or die(mysql_error());
 //echo $query;
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

echo '</table>';

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

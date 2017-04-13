<?php
// menggunakan class phpExcelReader
include("excel_reader2.php");

// koneksi ke mysql
include("conn.php");
include("import_honor_mk_interface.php");

//inisialisasi
$tahun = $_POST["tahun"];
$bulan = $_POST["bulan"];
$Kode = 1;
$data_gagal = "";
$data_gagal = array();

if ($bulan == "Februari" or $bulan == "Maret" or $bulan == "April" or $bulan == "Mei" or $bulan == "Juni"){
	$tahun_akad = $tahun - 1;
	$Semester = 2;
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
	$Id = $data->val($i,2);
	$HonorXuSkemaInti = $data->val($i,45);
	$HonorXfSkemaInti = $data->val($i,46);
	$HonorXfSkemaLain = $data->val($i,47);
	$HonorXfLintasFak = $data->val($i,48);
	$HonorPDPT = $data->val($i,49);
	$HonorBhsAsing = $data->val($i,51);
	$TotalHonorFak = $data->val($i,52);
	$TotalHonor = $data->val($i,53);
	$IkutHitung = $data->val($i,55);
	
	if(empty($HonorXuSkemaInti)) $HonorXuSkemaInti = 0;
	if(empty($HonorXfSkemaInti)) $HonorXfSkemaInti = 0;
	if(empty($HonorXfSkemaLain)) $HonorXfSkemaLain = 0;
	if(empty($HonorXfLintasFak)) $HonorXfLintasFak = 0;
	if(empty($HonorPDPT)) $HonorPDPT = 0;
	if(empty($HonorBhsAsing)) $HonorBhsAsing = 0;
	if(empty($TotalHonorFak)) $TotalHonorFak = 0;
	if(empty($TotalHonor)) $TotalHonor = 0;	
	if(empty($IkutHitung)) $IkutHitung = 0;	

	// setelah data dibaca, sisipkan ke dalam tabel temp
  $query = "INSERT INTO temp (id, IkutHitung, XuSkemaInti, XfSkemaInti, XfSkemaLain, XfLintasFak, PDPT, BhsAsing, TotalHonorFak, TotalHonor)
			VALUE ($Id, $IkutHitung, $HonorXuSkemaInti, $HonorXfSkemaInti, $HonorXfSkemaLain, $HonorXfLintasFak, $HonorPDPT, $HonorBhsAsing, $TotalHonorFak, $TotalHonor)";
			
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

// setelah data dibaca, sisipkan ke dalam tabel kalban

$query = "UPDATE kalban a, temp b 
		SET HonorXuSkemaInti = XuSkemaInti,
			HonorXfSkemaInti = XfSkemaInti,
			HonorXfSkemaLain = XfSkemaLain,
			HonorXfLintasFak = XfLintasFak,
			a.HonorPDPT = b.PDPT,
			a.HonorBhsAsing = b.BhsAsing,
			a.TotalHonorFak = b.TotalHonorFak,
			a.TotalHonor = b.TotalHonor,			
			a.IkutHitung = b.IkutHitung
		WHERE tahun = $tahun and bulan = '$vbulan' and a.id = b.id";
			
$hasil = mysql_query($query);


//hapus data sementara
$query = "DELETE FROM temp";
$hasil = mysql_query($query);

// tampilan status sukses dan gagal
echo "
<p><b>Proses import data selesai<b></br>
Jumlah data yang sukses diupdate : ".$sukses."<br>
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

<?php
//koneksi ke database
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();

$kodeorganisasi = $_SESSION["kodeorganisasi"];
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];

/*$bulan_gasal = $_POST["bulan_gasal"];
$bulan_genap = $_POST["bulan_genap"];

if (isset($bulan_gasal))
{
	$bulan = $bulan_gasal;
} 
else 
{
	$bulan = $bulan_genap;
}*/

switch($vbulan)
{
	case "Januari":
		$hadiraktual = "hadirjanuari";
		$bulan = "01";
		break;
	case "Februari":
		$hadiraktual = "hadirfebruari";
		$bulan = "02";
		break;
	case "Maret":
		$hadiraktual = "hadirmaret";
		$bulan = "03";
		break;
	case "April":
		$hadiraktual = "hadirapril";
		$bulan = "04";
		break;
	case "Mei":
		$hadiraktual = "hadirmei";
		$bulan = "05";
		break;
	case "Juni":
		$hadiraktual = "hadirjuni";
		$bulan = "06";
		break;
	case "Juli":
		$hadiraktual = "hadirjuli";
		$bulan = "07";
		break;
	case "Agustus":
		$hadiraktual = "hadiragustus";
		$bulan = "08";
		break;
	case "September":
		$hadiraktual = "hadirseptember";
		$bulan = "09";
		break;
	case "Oktober":
		$hadiraktual = "hadiroktober";
		$bulan = "10";
		break;
	case "November":
		$hadiraktual = "hadirnovember";
		$bulan = "11";
		$namaBulan = "November";
		break;
	case "Desember":
		$hadiraktual = "hadirdesember";
		$bulan = "12";
		break;
}

$xuskemainti = "XuSkemaInti".$bulan;
$xfskemainti = "XfSkemaInti".$bulan;
$xfskemalain = "XfSkemaLain".$bulan;
$xflintasfak = "XfLintasFak".$bulan;
$totalhonor = "TotalHonor".$bulan;

if ($_SESSION["username"]=="admin" or $_SESSION["username"]=="remunerasifisipui"){
	$kode_prodi = $_POST["kode_prodi"];
	#ambil data organisasi
	$qprodi = "select * from organisasi where kodeorganisasi = '$kode_prodi'";
	$sqlprodi = mysql_query($qprodi) or die ("Pesan Error : ".mysql_error());
	while ($rowprodi = mysql_fetch_array($sqlprodi)){
		$kodeorganisasi = $rowprodi["query1"];
		$_SESSION["programstudi"] = $rowprodi["programstudi"];		
		$_SESSION["orderby"] = $rowprodi["query2"];
		$_SESSION["ketuaprogram"] = $rowprodi["ketuaprogramstudi"];
		$_SESSION["nip"] = $rowprodi["nip"];	
	}
} else {
	$kodeorganisasi = $_SESSION['kodeorganisasi'];
	$kd_organisasi = $_SESSION['kode'];
}

#ambil data di tabel dan masukkan ke array
$judullaporan = "Laporan Kehadiran dan Honor Pengajar Periode $namaBulan $tahun";
$_SESSION["judullaporan"] = $judullaporan;

$query = "select namamatakuliah, namakelas, namapengajar, hadiraktual, kehadiranseharusnya, honorxuskemainti, honorxfskemainti, honorxfskemalain, honorxflintasfak, totalhonor
			FROM kalban WHERE kodeorganisasi = '$kd_organisasi' and tahun = $tahun and bulan = '$bulan'
			ORDER BY namamatakuliah, kodekelas";

$sql = mysql_query ($query) or die (mysql_error());
$data = array();
while ($row = mysql_fetch_assoc($sql)) {
	array_push($data, $row);
}

#hitung total
$totalhonorxuskemainti = 0;
$totalhonorxfskemainti = 0;
$totalhonorxfskemalain = 0;
$totalhonorxflintasfak = 0;
$totalhonorsemua = 0;
$i = 0;
$rows = mysql_num_rows($sql);

for ($i; $i<$rows; $i++) {	
	$totalhonorxuskemainti += $data["$i"]["honorxuskemainti"];
	$totalhonorxfskemainti += $data["$i"]["honorxfskemainti"];
	$totalhonorxfskemalain += $data["$i"]["honorxfskemalain"];
	$totalhonorxflintasfak += $data["$i"]["honorxflintasfak"];
	$totalhonorsemua += $data["$i"]["totalhonor"];	
}

#setting judul laporan dan header tabel
$header = array(
	array("label"=>"NAMA MATA KULIAH", "length"=>65, "align"=>"C", "align2"=>"L"),
	array("label"=>"NAMA KELAS", "length"=>35, "align"=>"C", "align2"=>"L"),
	array("label"=>"NAMA PENGAJAR", "length"=>55, "align"=>"C", "align2"=>"L"),
	array("label"=>"HADIR AKTUAL", "length"=>15, "align"=>"C", "align2"=>"C"),
	array("label"=>"WAJIB HADIR", "length"=>15, "align"=>"C", "align2"=>"C"),
	array("label"=>"Xu SKEMA INTI", "length"=>18, "align"=>"C", "align2"=>"R"),
	array("label"=>"Xf SKEMA INTI", "length"=>18, "align"=>"C", "align2"=>"R"),
	array("label"=>"Xf SKEMA LAIN", "length"=>18, "align"=>"C", "align2"=>"R"),
	array("label"=>"Xf LINFAK", "length"=>18, "align"=>"C", "align2"=>"R"),
	array("label"=>"TOTAL HONOR", "length"=>20, "align"=>"C", "align2"=>"R")
);
 
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
		$this->SetFont('Arial','B','8');
		$this->Cell(0,4, 'Universitas Indonesia', '0', 1, 'L');
		$this->Cell(15);
		$this->Cell(0,4, 'Fakultas Ilmu Sosial dan Ilmu Politik', '0', 1, 'L');
		$this->Cell(15);
		$this->Cell(0,4, $_SESSION["programstudi"], '0', 1, 'L');
		$this->Ln(4);
		$this->SetFont('Arial','B','9');
		$this->Cell(0,3, $_SESSION["judullaporan"], '0', 1, 'C');
		$this->Ln(2);
		
		#buat header tabel
		$this->SetFont('Arial','B','8');
		$this->SetFillColor(215,225,245);
		$this->SetTextColor(0);
		$this->SetDrawColor(215,225,245);
		$this->Cell(65,5, '', 1, 0, 'C', true);
		$this->Cell(35,5, '', 1, 0, 'C', true);
		$this->Cell(55,5, '', 1, 0, 'C', true);
		$this->Cell(15,5, 'Hadir', 1, 0, 'C', true);
		$this->Cell(15,5, 'Wajib', 1, 0, 'C', true);
		$this->Cell(18,5, 'Xu Skema', 1, 0, 'C', true);
		$this->Cell(18,5, 'Xf Skema', 1, 0, 'C', true);
		$this->Cell(18,5, 'Xf Skema', 1, 0, 'C', true);
		$this->Cell(18,5, 'Xf', 1, 0, 'C', true);
		$this->Cell(20,5, 'Total', 1, 1, 'C', true);
		$this->Cell(65,5, 'Nama Mata Kuliah', 1, 0, 'C', true);
		$this->Cell(35,5, 'Nama Kelas', 1, 0, 'C', true);
		$this->Cell(55,5, 'Nama Pengajar', 1, 0, 'C', true);
		$this->Cell(15,5, 'Aktual', 1, 0, 'C', true);
		$this->Cell(15,5, 'Hadir', 1, 0, 'C', true);
		$this->Cell(18,5, 'Inti', 1, 0, 'C', true);
		$this->Cell(18,5, 'Inti', 1, 0, 'C', true);
		$this->Cell(18,5, 'Lain', 1, 0, 'C', true);
		$this->Cell(18,5, 'Lin.Fak', 1, 0, 'C', true);
		$this->Cell(20,5, 'Honor', 1, 1, 'C', true);

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
 
#tampilkan data tabelnya
$pdf->SetFillColor(238,249,269);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(238,249,269);
$pdf->SetFont('Arial','','8');
$fill = false;

foreach ($data as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		if (number_format($cell)==0){
			$cell = $cell;
		} else {
			$cell = number_format($cell);
		}
		$pdf->Cell($header[$i]['length'], 8, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
}

#total masing-masing honor
$pdf->Ln(1);
$pdf->SetFillColor(238,249,269);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(221,232,252);
$pdf->SetFont('Arial','B','8');
$pdf->cell(185);
$pdf->cell(18,8,number_format($totalhonorxuskemainti),1,0,'R',true);
$pdf->cell(18,8,number_format($totalhonorxfskemainti),1,0,'R',true);
$pdf->cell(18,8,number_format($totalhonorxfskemalain),1,0,'R',true);
$pdf->cell(18,8,number_format($totalhonorxflintasfak),1,0,'R',true);
$pdf->cell(20,8,number_format($totalhonorsemua),1,0,'R',true);
 
#output file PDF
$pdf->Output();
?>
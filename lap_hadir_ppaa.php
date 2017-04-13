<?php
//koneksi ke database
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();
/*
$kodeorganisasi = $_SESSION["kodeorganisasi"];
$tahun = $_POST["tahun"];
$bulan_gasal = $_POST["bulan_gasal"];
$bulan_genap = $_POST["bulan_genap"];

if (isset($bulan_gasal))
{
	$bulan = $bulan_gasal;
} 
else 
{
	$bulan = $bulan_genap;
}

switch($bulan)
{
	case "Januari":
		$hadiraktual = "hadirjanuari";
		break;
	case "Februari":
		$hadiraktual = "hadirfebruari";
		break;
	case "Maret":
		$hadiraktual = "hadirmaret";
		break;
	case "April":
		$hadiraktual = "hadirapril";
		break;
	case "Mei":
		$hadiraktual = "hadirmei";
		break;
	case "Juni":
		$hadiraktual = "hadirjuni";
		break;
	case "Juli":
		$hadiraktual = "hadirjuli";
		break;
	case "Agustus":
		$hadiraktual = "hadiragustus";
		break;
	case "September":
		$hadiraktual = "hadirseptember";
		break;
	case "Oktober":
		$hadiraktual = "hadiroktober";
		break;
	case "November":
		$hadiraktual = "hadirnovember";
		break;
	case "Desember":
		$hadiraktual = "hadirdesember";
		break;
}
*/

$ahun = 2011;
$bulan = "Desember";

#ambil data di tabel dan masukkan ke array

$judullaporan = "Laporan Kehadiran Pengajar Periode Desember 2011";
$_SESSION["judullaporan"] = $judullaporan;

$query1 = "SELECT hari, jam, namamatakuliah, namakelas, namapengajar, hadirdesember
		   FROM data 
		   WHERE ((kodeorganisasi = '01.02.09.01' or kodeorganisasi = '02.02.09.01' or kodeorganisasi = '05.02.09.01' or kodeorganisasi = '08.03.09.01'
				or kodeorganisasi = '09.03.09.01' or kodeorganisasi = '10.03.09.01' or kodeorganisasi = '01.04.09.01' or kodeorganisasi = '02.05.09.01'
				or kodeorganisasi = '05.05.09.01' or kodeorganisasi = '01.06.09.01' or kodeorganisasi = '02.07.09.01' or kodeorganisasi = '01.08.09.01')
				or (kodemk = 'ISP20044' or kodemk = 'ISP20036' or kodemk = 'ISP20031' or kodemk = 'ISP20043' or kodemk = 'ISP20035' or kodemk = 'ISP22027') 
				and (left(kodemk,3) <> 'UUI' and left(kodemk,3) <> 'UNI')) and flagtampil=1 and hari <> '' and hari = ";
$query2 = " ORDER BY hari desc, substr(jam,1,5), ruang, namamatakuliah, kodekelas";
			
/* terusin lagi... puyeng...
$vhari = array("senin","selasa","rabu","kamis","jumat","sabtu");
$data = array();
foreach ($vhari as $hari){
	$i = 0;
	$data.$i = array();
	$query = $query1."'$hari[$i]'".$query2;
	$sql = mysql_query ($query);	
	$jmlbaris = mysql_num_rows($sql);
	
	if ($jmlbaris > 1){
		while ($row = mysql_fetch_assoc($sql)){
			array_push($data.$i, $row);
		}
	}	
	$i++;
}
*/
		
#data senin
$senin = $query1."'senin'".$query2;
$sql = mysql_query ($senin);
$datasenin = array();
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 1){
	while ($row = mysql_fetch_assoc($sql)){
		array_push($datasenin, $row);
	}
}

#data selasa
$selasa = $query1."'selasa'".$query2;
$sql = mysql_query ($selasa);
$dataselasa = array();
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 1){
	while ($row = mysql_fetch_assoc($sql)){
		array_push($dataselasa, $row);
	}
}

#data rabu
$rabu = $query1."'rabu'".$query2;
$sql = mysql_query ($rabu);
$datarabu = array();
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 1){
	while ($row = mysql_fetch_assoc($sql)){
		array_push($datarabu, $row);
	}
}

#data kamis
$kamis = $query1."'kamis'".$query2;
$sql = mysql_query ($kamis);
$datakamis = array();
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 1){
	while ($row = mysql_fetch_assoc($sql)){
		array_push($datakamis, $row);
	}
}

#data jumat
$jumat = $query1."'jumat'".$query2;
$sql = mysql_query ($jumat);
$datajumat = array();
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 1){
	while ($row = mysql_fetch_assoc($sql)){
		array_push($datajumat, $row);
	}
}

#data sabtu
$sabtu = $query1."'sabtu'".$query2;
$sql = mysql_query ($sabtu);
$datasabtu = array();
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 1){
	while ($row = mysql_fetch_assoc($sql)){
		array_push($datasabtu, $row);
	}
}

 
#setting judul laporan dan header tabel
$header = array(
	array("label"=>"HARI", "length"=>10, "align"=>"C", "align2"=>"L"),
	array("label"=>"WAKTU", "length"=>18, "align"=>"C", "align2"=>"C"),
	array("label"=>"NAMA MATA KULIAH", "length"=>60, "align"=>"C", "align2"=>"L"),
	array("label"=>"NAMA KELAS", "length"=>35, "align"=>"C", "align2"=>"L"),
	array("label"=>"NAMA PENGAJAR", "length"=>53, "align"=>"C", "align2"=>"L"),
	array("label"=>"JML HADIR", "length"=>17, "align"=>"C", "align2"=>"C")
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
		$this->SetDrawColor(238,249,269);
		$this->Cell(10,5, 'HARI', 1, 0, 'C', true);
		$this->Cell(18,5, 'WAKTU', 1, 0, 'C', true);
		$this->Cell(60,5, 'NAMA MATA KULIAH', 1, 0, 'L', true);
		$this->Cell(35,5, 'NAMA KELAS', 1, 0, 'L', true);
		$this->Cell(53,5, 'NAMA PENGAJAR', 1, 0, 'L', true);
		$this->Cell(17,5, 'JML HADIR', 1, 1, 'C', true);
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

$pdf = new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();

$counter = 45;
 
#tampilkan data tabelnya
$pdf->SetFillColor(238,249,269);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(238,249,269);
$pdf->SetFont('Arial','','8');
$fill = false;

foreach ($datasenin as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
	$counter = $counter + 5;
}
$pdf->Ln();
foreach ($dataselasa as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
	$counter = $counter + 5;
}
$pdf->Ln();
foreach ($datarabu as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
	$counter = $counter + 5;
}
$pdf->Ln();
foreach ($datakamis as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
	$counter = $counter + 5;
}
$pdf->Ln();
foreach ($datajumat as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
	$counter = $counter + 5;
}
$pdf->Ln();
foreach ($datasabtu as $baris) {
	$i = 0;
	foreach ($baris as $cell) {
		$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
		$i++;
	}	
	$fill = !$fill;
	$pdf->Ln();
	$counter = $counter + 5;
}

#Sign Ketua Program
$tanggal = "Depok, ".date("j")." Desember 2011";

$pdf->SetFont('Arial','B','8');
if ($_SESSION['programstudi'] == "Program Sarjana Reguler Sosiologi" or $_SESSION['programstudi'] == "Program Sarjana Reguler Ilmu Kesejahteraan Sosial"){ //halaman baru sign ketua program
	$pdf->Ln(30);
	$pdf->Cell(100);
	$pdf->Cell(0,4, $tanggal, '0', 1, 'L');
	$pdf->Cell(100);
	$pdf->Cell(0,4, 'Mengetahui,', '0', 1, 'L');
	$pdf->Cell(100);
	$pdf->Cell(0,4, 'Ketua '.$_SESSION['programstudi'], '0', 1, 'L');
	$pdf->Ln(10);
	$pdf->Cell(100);
	$pdf->Cell(0,4, $_SESSION['ketuaprogram'], '0', 1, 'L');
	$pdf->Cell(100);
	$pdf->Cell(0,4, 'NIP/NUP: '.$_SESSION['nip'], '0', 1, 'L');
} else {
	$pdf->Ln(8);
	$pdf->Cell(100);
	$pdf->Cell(0,4, $tanggal, '0', 1, 'L');
	$pdf->Cell(100);
	$pdf->Cell(0,4, 'Mengetahui,', '0', 1, 'L');
	$pdf->Cell(100);
	$pdf->Cell(0,4, 'Winarto dan kawan-kawan ', '0', 1, 'L');
	$pdf->Ln(10);
	$pdf->Cell(100);
	$pdf->Cell(0,4, $_SESSION['ketuaprogram'], '0', 1, 'L');
	$pdf->Cell(100);
	$pdf->Cell(0,4, 'NIP: ...sedang dalam perjuangan... |:-( ', '0', 1, 'L');
}


#output file PDF
$pdf->Output();
?>
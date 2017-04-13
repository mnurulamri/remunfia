<?php
//koneksi ke database
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();
$kodeorganisasi = $_SESSION["kodeorganisasi"];
$tahun = $_POST["tahun"];
$semester = $_POST["semester"];
$vtahun = $tahun + 1;
$tahunakademik = $tahun."/".$vtahun;

if($semester == "Gasal"){
	$vsemester = 1;
} else {
	$vsemester = 2;
}

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
} else { //jika bukan admin	
	$kodeorganisasi = $_SESSION['kodeorganisasi'];
}

#setting judul laporan dan header tabel
$header = array(
	array("label"=>"Nama Pengajar", "length"=>60, "align"=>"L", "align2"=>"L"),
	array("label"=>"Skema", "length"=>35, "align"=>"L", "align2"=>"L"),
	array("label"=>"TotalHonorSeptember", "length"=>20, "align"=>"C", "align2"=>"R"),
	array("label"=>"Hadir September", "length"=>9, "align"=>"C", "align2"=>"C"),
	array("label"=>"TotalHonorOktober", "length"=>20, "align"=>"C", "align2"=>"R"),
	array("label"=>"Hadir Oktober", "length"=>9, "align"=>"C", "align2"=>"C"),
	array("label"=>"TotalHonorNovember", "length"=>20, "align"=>"C", "align2"=>"R"),
	array("label"=>"Hadir November", "length"=>9, "align"=>"C", "align2"=>"C"),
	array("label"=>"TotalHonorDesember", "length"=>20, "align"=>"C", "align2"=>"R"),
	array("label"=>"Hadir Desember", "length"=>9, "align"=>"C", "align2"=>"C"),
	array("label"=>"TotalHonorjanuari", "length"=>20, "align"=>"C", "align2"=>"R"),	
	array("label"=>"Hadir Januari", "length"=>9, "align"=>"C", "align2"=>"C"),
	array("label"=>"Total Honor", "length"=>20, "align"=>"C", "align2"=>"R"),
	array("label"=>"Total Hadir", "length"=>9, "align"=>"C", "align2"=>"C"),
	array("label"=>"Wajib Hadir", "length"=>10, "align"=>"C", "align2"=>"C")
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



#setting judul laporan
$judullaporan = "Laporan Honor dan Kehadiran Pengajar Semester $semester Tahun Akademik $tahunakademik";
$_SESSION["judullaporan"] = $judullaporan;

#ambil data mata kuliah
$querymk = "select distinct namamatakuliah, namakelas, kodekelas 
			FROM data WHERE $kodeorganisasi and semester = $vsemester and flagtampil=1 and flagaep=0
			ORDER BY namamatakuliah, kodekelas";
			
$sqlmk = mysql_query($querymk) or die ("Data Tidak Ditemukan");
$datamk = array();

while($rowmk = mysql_fetch_assoc($sqlmk)){
	array_push($datamk, $rowmk);
}
$y = 27;
$w = 0;

#tampilkan data untuk masing-masing grup mata kuliah
foreach($datamk as $groupmk){
	#setting nama mata kuliah dan nama kelas
	$kodekelas = $groupmk["kodekelas"];
	$namakelas = $groupmk["namakelas"];
	
	#tampilkan nama grup matakuliah dan nama kelasnya
	$pdf->SetFillColor(333,333,333);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(777,777,777);
	$pdf->SetFont('Arial','BI','8');
	$fill = true;
	$pdf->cell(65,5,$groupmk['namamatakuliah'],1,0,"L",$fill);
	
	#buat header tabel
	$pdf->SetFont('Arial','B','8');
	$pdf->SetFillColor(238,249,269);
	$pdf->SetTextColor(88,89,87);
	$pdf->SetDrawColor(215,225,245);		
	$pdf->Cell(30);
	$pdf->Cell(29,5, 'September', 1, 0, 'C', true);
	$pdf->Cell(29,5, 'Oktober', 1, 0, 'C', true);
	$pdf->Cell(29,5, 'November', 1, 0, 'C', true);
	$pdf->Cell(29,5, 'Desember', 1, 0, 'C', true);
	$pdf->Cell(29,5, 'Januari', 1, 0, 'C', true);
	$pdf->Cell(29,5, 'Total', 1, 0, 'C', true);
	$pdf->Cell(10,5, 'Wajib', 1, 1, 'C', true);
	#$pdf->SetXY($y+$w,80);
	$pdf->Cell(60,5, 'Nama Pengajar', 1, 0, 'L', true);
	$pdf->Cell(35,5, 'Skema', 1, 0, 'L', true);
	$pdf->Cell(20,5, 'Honor', 1, 0, 'C', true);
	$pdf->Cell(9,5, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(20,5, 'Honor', 1, 0, 'C', true);
	$pdf->Cell(9,5, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(20,5, 'Honor', 1, 0, 'C', true);
	$pdf->Cell(9,5, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(20,5, 'Honor', 1, 0, 'C', true);
	$pdf->Cell(9,5, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(20,5, 'Honor', 1, 0, 'C', true);
	$pdf->Cell(9,5, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(20,5, 'Honor', 1, 0, 'C', true);
	$pdf->Cell(9,5, 'Hadir', 1, 0, 'C', true);
	$pdf->Cell(10,5, 'Hadir', 1, 1, 'C', true);	
	
	#ambil data dari tabel dan masukkan ke array untuk masing-masing mata kuliah
	$query = "select namapengajar, skema,totalhonorseptember,  hadirseptember, totalhonoroktober, hadiroktober, totalhonornovember, hadirnovember, totalhonordesember, hadirdesember, totalhonorjanuari, hadirjanuari, 
					 hadiroktober+hadirnovember+hadirdesember+hadirjanuari as totalhadir,
					 totalhonoroktober+hadirnovember+totalhonornovember+hadirdesember+totalhonordesember+hadirjanuari+totalhonorjanuari as totalhonor,
					 kehadiranseharusnya
				FROM data WHERE $kodeorganisasi and semester = $vsemester and flagtampil=1 and flagaep=0 and kodekelas='$kodekelas' and ikuthitung=1
				ORDER BY namamatakuliah, kodekelas";
				
	$sql = mysql_query ($query) or die ("Data Tidak Ditemukan!..");
	$data = array();
	
	while ($row = mysql_fetch_assoc($sql)) {
		array_push($data, $row);
	}
	
	foreach ($data as $baris) {
		$i = 0;
		$totalhadir = 0;
		$totalhonor = 0;
		$honor1 = 0
		$j = 0;
		
		#format tabel
		$pdf->SetDrawColor(215,225,245);
		$pdf->SetTextColor(0);
		$pdf->SetFont('Arial','','8');
		$fill = false;
		
		foreach ($baris as $cell) {
			if($cell == null){
				$cell = 0;
			} else {
				$cell = $cell;
			}
			#hitung total hadir		
			if($i == 2 or $i == 4 or $i ==6 or $i == 8 or $i == 10){
				$totalhonor += $cell;
			} else {
				$cell = $cell;
			}
			
			#hitung total honor	
			if($i == 3){
				$honor1 += $cell;
			}
			
			if($i == 3 or $i == 5 or $i ==7 or $i == 9 or $i == 11){
				$totalhadir += $cell;
			} else {
				$cell = $cell;
			}
			if($i == 12){
				$pdf->Cell($header[$i]['length'], 6, number_format($totalhonor), 1, '0', $header[$i]['align2'], $fill);
			} else if($i == 13){ 
				$pdf->Cell($header[$i]['length'], 6, $totalhadir, 1, '0', $header[$i]['align2'], $fill);
			} else if($i == 2 or $i ==4 or $i == 6 or $i == 8 or $i == 10){ 
				$pdf->Cell($header[$i]['length'], 6, number_format($cell), 1, '0', $header[$i]['align2'], $fill);
			} else {  //format biasa
				$pdf->Cell($header[$i]['length'], 6, $cell, 1, '0', $header[$i]['align2'], $fill);
			}
			
			$i++;
			$j++;
		}	
		$w = 5*$i;
		$pdf->Ln();
	}
	#kosongkan variabel $data dan set kembali ke format array
	$data = "";
	$data = array();
	$pdf->ln();
}


$pdf->Ln(1);
$pdf->SetFillColor(238,249,269);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(221,232,252);
$pdf->SetFont('Arial','B','8');
//$pdf->cell(185);
$pdf->cell(18,8,number_format($honor1),1,0,'R',true);

#kembalikan session untuk admin
if ($_SESSION["username"]=="admin" or $_SESSION["username"]=="remunerasifisipui"){	
	$qprodi = "select * from organisasi where username = '$username'";
	$sqlprodi = mysql_query($qprodi) or die ("Pesan Error : ".mysql_error());
	while ($rowprodi = mysql_fetch_array($sqlprodi)){
		$_SESSION["kodeorganisasi"] = $rowprodi["query1"];
		$_SESSION["programstudi"] = $rowprodi["programstudi"];		
		$_SESSION["orderby"] = $rowprodi["query2"];
		$_SESSION["ketuaprogram"] = $rowprodi["ketuaprogramstudi"];
		$_SESSION["nip"] = $rowprodi["nip"];	
	}
}

#output file PDF
$pdf->Output();
?>
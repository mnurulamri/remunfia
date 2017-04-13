<?php
//koneksi ke database test
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();

if (isset($_POST["kode_prodi"])){
	$kode_prodi = $_POST["kode_prodi"];
}

$kodeorganisasi = $_SESSION["kodeorganisasi"];
$tahun = $_POST["tahun"];
$tahun_akad = $tahun;
$semester = $_POST["semester"];
$_SESSION["semester"] = $semester;
$vtahun = $tahun + 1;
$tahunakademik = $tahun."/".$vtahun;
$username = $_SESSION["username"];

if($semester == "Gasal"){
	$bulan = array("HadirSeptember","HadirOktober","HadirNovember","HadirDesember","HadirJanuari");
	$header = array("Hadir September","Hadir Oktober","Hadir November","Hadir Desember","Hadir Januari");
} else {
	$bulan = array("HadirFebruari","HadirMaret","HadirApril","HadirMei","HadirJuni");
	$header = array("Hadir Februari","Hadir Maret","Hadir April","Hadir Mei","Hadir Juni");
}

if($semester == "Gasal"){
	$smt = 1;
	//$tahun = $tahun;
} else {
	$smt = 2;
	$tahun = $tahun + 1;
}

#ambil data di tabel dan masukkan ke array
$judullaporan = "Rekap Honor Pengajar Semester $semester Tahun Akademik $tahunakademik";
$_SESSION["judullaporan"] = $judullaporan;

if ($_SESSION["username"]=="admin" or $_SESSION["username"]=="remunerasifisipui" or $_SESSION["username"]=="zaenal"){	
	$qprodi = "select * from organisasi where kodeorganisasi = '$kode_prodi'";
	$sqlprodi = mysql_query($qprodi) or die ("Pesan Error : ".mysql_error());
	while ($rowprodi = mysql_fetch_array($sqlprodi)){
		$kodeorganisasi = $rowprodi["query1"];
		$_SESSION["programstudi"] = $rowprodi["programstudi"];		
		$_SESSION["orderby"] = $rowprodi["query2"];
		$_SESSION["ketuaprogram"] = $rowprodi["ketuaprogramstudi"];
		$_SESSION["nip"] = $rowprodi["nip"];	
	}
	
	if ($semester == "Gasal"){

		$query = "SELECT NamaMataKuliah, NamaKelas, NamaPengajar,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='09',totalhonor,0)) as HadirSeptember,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='10',totalhonor,0)) as HadirOktober,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='11',totalhonor,0)) as HadirNovember,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='12',totalhonor,0)) as HadirDesember,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun+1 and bulan='01',totalhonor,0)) as HadirJanuari,
					KehadiranSeharusnya
				FROM kalban a, jadwal b
				WHERE $kodeorganisasi and a.tahun_akad = $tahun_akad and semester = $smt and ikuthitung=1 and flagaep=0 and flagtampil=1 and
					  b.tahun_akad = $tahun_akad and smt = $smt and kodekelas = kd_kelas and kodepdpt=0 and (kodepasca='0' or kodepasca='')
				group by kode
				order by NamaMataKuliah, NamaKelas, NamaPengajar";
		
	} else {

		$query = "SELECT NamaMataKuliah, NamaKelas, NamaPengajar, 
					sum(if(a.tahun_akad=$tahun_akad and  tahun=$tahun and bulan='02',totalhonor,0)) as 'HadirFebruari',		   
					sum(if(a.tahun_akad=$tahun_akad and  tahun=$tahun and bulan='03',totalhonor,0)) as 'HadirMaret',		   
					sum(if(a.tahun_akad=$tahun_akad and  tahun=$tahun and bulan='04',totalhonor,0)) as 'HadirApril',		   
					sum(if(a.tahun_akad=$tahun_akad and  tahun=$tahun and bulan='05',totalhonor,0)) as 'HadirMei',		   
					sum(if(a.tahun_akad=$tahun_akad and  tahun=$tahun and bulan='06',totalhonor,0)) as 'HadirJuni',
					KehadiranSeharusnya
				FROM kalban a, jadwal b
				WHERE $kodeorganisasi and a.tahun_akad = $tahun_akad and semester = $smt and ikuthitung=1 and flagaep=0 and flagtampil=1 and
					  b.tahun_akad = $tahun_akad and smt = $smt and kodekelas = kd_kelas and kodepdpt=0 and (kodepasca='0' or kodepasca='')
				group by kode
				order by NamaMataKuliah, NamaKelas, NamaPengajar";

	}		
	
	$sql = mysql_query ($query) or die ("Pesan Error : ".mysql_error());
	$data = array();
	while ($row = mysql_fetch_object($sql)) {
		$data[$row->NamaKelas][] = $row;
	}
	
} else {

	$kodeorganisasi = $_SESSION["kodeorganisasi"];
	
	if ($semester == "Gasal"){

		$query = "SELECT NamaMataKuliah, NamaKelas, NamaPengajar,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='09',totalhonor,0)) as honorseptember, 
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='10',totalhonor,0)) as honoroktober, 
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='11',totalhonor,0)) as honornopember,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='12',totalhonor,0)) as honordesember,
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun+1 and bulan='01',totalhonor,0)) as honorjanuari,
					KehadiranSeharusnya
				FROM kalban a, jadwal b
				WHERE $kodeorganisasi and a.tahun_akad = $tahun_akad and semester = $smt and ikuthitung=1 and flagaep=0 and flagtampil=1 and
					  b.tahun_akad = $tahun_akad and smt = $smt and kodekelas = kd_kelas and kodepdpt=0 and (kodepasca='0' or kodepasca='')
				group by kode
				order by NamaMataKuliah, NamaKelas, NamaPengajar";
		
	} else {

		$query = "SELECT NamaMataKuliah, NamaKelas, NamaPengajar, 
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='02',totalhonor,0)) as 'HadirFebruari',		   
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='03',totalhonor,0)) as 'HadirMaret',		   
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='04',totalhonor,0)) as 'HadirApril',		   
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='05',totalhonor,0)) as 'HadirMei',		   
					sum(if(a.tahun_akad=$tahun_akad and tahun=$tahun and bulan='06',totalhonor,0)) as 'HadirJuni',
					KehadiranSeharusnya
				FROM kalban a, jadwal b
				WHERE $kodeorganisasi and a.tahun_akad = $tahun_akad and semester = $smt and ikuthitung=1 and flagaep=0 and flagtampil=1 and
					  b.tahun_akad = $tahun_akad and smt = $smt and kodekelas = kd_kelas and kodepdpt=0 and (kodepasca='0' or kodepasca='')
				group by kode
				order by NamaMataKuliah, NamaKelas, NamaPengajar";
	}			
	
	$sql = mysql_query ($query) or die ("Pesan Error : ".mysql_error());
	$data = array();
	$datahonor = array();
	
	while ($row = mysql_fetch_object($sql)) {
		$data[$row->NamaKelas][] = $row;
	}

}



#setting judul laporan dan header tabel
if ($semester == "Gasal"){
	$header = array(
		array("label"=>"Nama Mata Kuliah", "length"=>65, "align"=>"L", "align2"=>"L"),
		array("label"=>"Nama Kelas", "length"=>35, "align"=>"L", "align2"=>"L"),
		array("label"=>"Nama Pengajar", "length"=>60, "align"=>"L", "align2"=>"L"),
		array("label"=>"Hadir September", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir Oktober", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir November", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir Desember", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir Januari", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Total Hadir", "length"=>20, "align"=>"C", "align2"=>"R")
	);
} else {
	$header = array(
		array("label"=>"Nama Mata Kuliah", "length"=>65, "align"=>"L", "align2"=>"L"),
		array("label"=>"Nama Kelas", "length"=>35, "align"=>"L", "align2"=>"L"),
		array("label"=>"Nama Pengajar", "length"=>60, "align"=>"L", "align2"=>"L"),
		array("label"=>"Hadir Februari", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir Maret", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir April", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir Mei", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Hadir Juni", "length"=>20, "align"=>"C", "align2"=>"R"),
		array("label"=>"Total Hadir", "length"=>20, "align"=>"C", "align2"=>"R")
	);
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
		//$this->SetDrawColor(238,249,269); garis yang lama
		$this->Cell(65,5, '', 1, 0, 'C', true);
		$this->Cell(35,5, '', 1, 0, 'C', true);
		$this->Cell(60,5, '', 1, 0, 'C', true);
		$this->Cell(120,5, 'Hadir', 1, 1, 'C', true);
		
		$this->Cell(65,5, 'Nama Mata Kuliah', 1, 0, 'L', true);
		$this->Cell(35,5, 'Nama Kelas', 1, 0, 'L', true);
		$this->Cell(60,5, 'Nama Pengajar', 1, 0, 'L', true);

		if ($_SESSION["semester"] == "Gasal"){
			$this->Cell(20,5, 'September', 1, 0, 'C', true);
			$this->Cell(20,5, 'Oktober', 1, 0, 'C', true);
			$this->Cell(20,5, 'November', 1, 0, 'C', true);
			$this->Cell(20,5, 'Desember', 1, 0, 'C', true);
			$this->Cell(20,5, 'Januari', 1, 0, 'C', true);
		} else {
			$this->Cell(20,5, 'Februari', 1, 0, 'C', true);
			$this->Cell(20,5, 'Maret', 1, 0, 'C', true);
			$this->Cell(20,5, 'April', 1, 0, 'C', true);
			$this->Cell(20,5, 'Mei', 1, 0, 'C', true);
			$this->Cell(20,5, 'Juni', 1, 0, 'C', true);		
		}

		$this->Cell(20,5, 'Total', 1, 1, 'C', true);
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
 
   
foreach ($data as $NamaKelas => $records){
    
    #tampilkan data tabelnya
    $pdf->SetFillColor(238,249,269);
    $pdf->SetTextColor(0);
    $pdf->SetDrawColor(215,225,245);
    $pdf->SetFont('Arial','','8');
    $fill = true;
               
    foreach ($records as $baris) {
        $i = 0;
        $totalhonor = 0;
        $j = 0;
        foreach ($baris as $cell) {
            if($cell == null){
                $cell = 0;
            } else {
                $cell = $cell;
            }	
			
			#hitung total honor
			if ($i == 3) $honor1 += $cell;
			if ($i == 4) $honor2 += $cell;
			if ($i == 5) $honor3 += $cell;
			if ($i == 6) $honor4 += $cell;
			if ($i == 7) $honor5 += $cell;
			
            if($i == 3 or $i == 4 or $i ==5 or $i == 6 or $i == 7){
                $totalhonor += $cell;
				$grandtotal += $cell;
            } else {
                $cell = $cell;
            }
            if($i == 8){
                $pdf->Cell($header[$i]['length'], 5, number_format($totalhonor), 1, '0', $header[$i]['align2'], false);
            } else if($i == 3 or $i == 4 or $i ==5 or $i == 6 or $i == 7){
                $pdf->Cell($header[$i]['length'], 5, number_format($cell), 1, '0', $header[$i]['align2'], false);
            } else {
                $pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], false);
            }
           
            $i++;
            $j++;
        }	
        #$fill = !$fill;
        $pdf->Ln();
    }
               
    $pdf->Ln(1);
}
        
$pdf->Ln(1);
$pdf->SetFillColor(238,249,269);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(221,232,252);
$pdf->SetFont('Arial','B','8');
$pdf->cell(160);
$pdf->cell(20,8,number_format($honor1),0,0,'R',true);
$pdf->cell(20,8,number_format($honor2),0,0,'R',true);
$pdf->cell(20,8,number_format($honor3),0,0,'R',true);
$pdf->cell(20,8,number_format($honor4),0,0,'R',true);
$pdf->cell(20,8,number_format($honor5),0,0,'R',true);
$pdf->cell(20,8,number_format($grandtotal),0,0,'R',true);
		
#kembalikan session untuk admin
if ($_SESSION["username"]=="admin" or $_SESSION["username"]=="remunerasifisipui" or $_SESSION["username"]=="zaenal"){	
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
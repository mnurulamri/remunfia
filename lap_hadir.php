<?php
//koneksi ke database
include("conn.php");

#setting session, hadir aktual, tahun dan bulan
if(!session_id()) session_start();
$username = $_SESSION["username"];
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];
#$bulan_genap = $_POST["bulan_genap"];

switch($vbulan)
{
	case "Januari":
		$bulan = "01";
		$hadiraktual = "hadirjanuari";
		break;
	case "Februari":
		$bulan = "02";
		$hadiraktual = "hadirfebruari";
		break;
	case "Maret":
		$bulan = "03";
		$hadiraktual = "hadirmaret";
		break;
	case "April":
		$bulan = "04";
		$hadiraktual = "hadirapril";
		break;
	case "Mei":
		$bulan = "05";
		$hadiraktual = "hadirmei";
		break;
	case "Juni":
		$bulan = "06";
		$hadiraktual = "hadirjuni";
		break;
	case "Juli":
		$bulan = "07";
		$hadiraktual = "hadirjuli";
		break;
	case "Agustus":
		$bulan = "08";
		$hadiraktual = "hadiragustus";
		break;
	case "September":
		$bulan = "09";
		$hadiraktual = "hadirseptember";
		break;
	case "Oktober":
		$bulan = "10";
		$hadiraktual = "hadiroktober";
		break;
	case "November":
		$bulan = "11";
		$hadiraktual = "hadirnovember";
		break;
	case "Desember":
		$bulan = "12";
		$hadiraktual = "hadirdesember";
		break;
}

if($bulan == "02" or $bulan == "03" or $bulan == "04" or $bulan == "05" or $bulan == "06" or $bulan == "07" or $bulan == "08"){
	$smt = 2;
	$tahun_akad = $tahun-1;
} else if($bulan == "01"){
	$smt = 1;
	$tahun_akad = $tahun-1;
} else {
	$smt = 1;
	$tahun_akad = $tahun;
}

#ambil data di tabel dan masukkan ke array
if ($_SESSION["username"]=="admin" or $_SESSION["username"]=="remunerasifisipui" or $_SESSION["username"]=="zaenal"){
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

#setting judul header
$judullaporan = "Laporan Kehadiran Pengajar Periode $vbulan $tahun";

$_SESSION["judullaporan"] = $judullaporan;
$header = array(
	array("label"=>"HARI", "length"=>10, "align"=>"C", "align2"=>"L"),
	array("label"=>"WAKTU", "length"=>18, "align"=>"C", "align2"=>"C"),
	array("label"=>"NAMA MATA KULIAH", "length"=>62, "align"=>"C", "align2"=>"L"),
	array("label"=>"NAMA KELAS", "length"=>33, "align"=>"C", "align2"=>"L"),
	array("label"=>"NAMA PENGAJAR", "length"=>53, "align"=>"C", "align2"=>"L"),
	array("label"=>"JML HADIR", "length"=>17, "align"=>"C", "align2"=>"C")
);
 
#sertakan library FPDF dan bentuk objek
require_once ("fpdf/fpdf.php");

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
		$this->Cell(62,5, 'NAMA MATA KULIAH', 1, 0, 'L', true);
		$this->Cell(33,5, 'NAMA KELAS', 1, 0, 'L', true);
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



#ambil data
//$kodeprodi = $_SESSION["kd_organisasi"];
$data = array();
if ($_SESSION["username"] == "ppaa"){
$query = "SELECT b.hari, b.jam, namamatakuliah, namakelas, namapengajar, hadiraktual 
		  FROM kalban a, jadwal b
		  WHERE $kodeorganisasi and flagtampil=1 and tahun = $tahun and bulan = '$bulan' and kodekelas = kd_kelas and b.tahun_akad = $tahun_akad and smt = $smt
		  ORDER BY b.flaghari, substr(b.jam,1,3), b.ruang, namamatakuliah";
} else {
$query = "SELECT b.hari, b.jam, namamatakuliah, namakelas, namapengajar, hadiraktual 
		  FROM kalban a, jadwal b
		  WHERE $kodeorganisasi and flagtampil=1 and tahun = $tahun and bulan = '$bulan' and kodekelas = kd_kelas and b.tahun_akad = $tahun_akad and smt = $smt and (kodepasca=0 or kodepasca='' or kodepasca=1)
		  ORDER BY b.flaghari, substr(b.jam,1,3), namamatakuliah, kodekelas";
}

$sql = mysql_query($query) or die ("Pesan Error Hari : ".mysql_error());
$jmlbaris = mysql_num_rows($sql);

if ($jmlbaris > 0){

while ($row = mysql_fetch_object($sql)){
	$data[$row->hari][] = $row;
}

#untuk masing-masing hari
foreach ($data as $hari => $records){
	#tampilkan datanya
	$pdf->SetFillColor(238,249,269);
	$pdf->SetTextColor(0);
	$pdf->SetDrawColor(238,249,269);
	$pdf->SetFont('Arial','','8');
	$fill = false;
	foreach ($records as $baris){
		$i = 0;
		foreach ($baris as $cell) {
			$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
			$i++;
		}	
		$fill = !$fill;
		$pdf->Ln();
	}
	$pdf->ln();
}

if($_SESSION['programstudi'] == "Program Sarjana Ekstensi Ilmu Administrasi Negara"){
	#Sign Ketua Program
	$pdf->ln();
	$tanggal = "Depok, ".date("j")." ".$vbulan." ".$tahun;
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(-9);
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
} else if ($_SESSION['programstudi'] == "Program Sarjana Reguler Ilmu Komunikasi"){
	#Sign Ketua Program
	$pdf->ln(-9);
	$tanggal = "Depok, ".date("j")." ".$vbulan." ".$tahun;
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(8);
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
} else if ($_SESSION['programstudi'] == "Program Sarjana Reguler Ilmu Administrasi Niaga"){
	#Sign Ketua Program
	$pdf->ln(70);
	$tanggal = "Depok, ".date("j")." ".$vbulan." ".$tahun;
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(8);
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
} else if ($_SESSION['programstudi'] == "Program Sarjana Paralel Kriminologi"){
	#Sign Ketua Program
	$pdf->ln(50);
	$tanggal = "Depok, ".DateToIndo();
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(8);
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
} else if ($_SESSION['programstudi'] == "Program Magister Ilmu Komunikasi"){
	#Sign Ketua Program
	$pdf->ln(50);
	$tanggal = "Depok, ".DateToIndo();
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(8);
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
} else if ($_SESSION['programstudi'] == "Program Magister Ilmu Politik"){
	#Sign Ketua Program
	$pdf->ln(-9);
	$tanggal = "Depok, ".DateToIndo();
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(8);
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
	#Sign Ketua Program
	$tanggal = "Depok, ".DateToIndo();
	$pdf->SetFont('Arial','B','8');
	$pdf->Ln(8);
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
}
	
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
} else {
	echo "
	<script language='JavaScript'>
		alert('Tidak Ada Data');
		window.close();
	</script>
	";
}

//fungsi tanggal
function DateToIndo() { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
        $BulanIndo = array("Januari", "Februari", "Maret",
                           "April", "Mei", "Juni",
                           "Juli", "Agustus", "September",
                           "Oktober", "November", "Desember");
    
        $tahun = date("Y"); 
        $bulan = date("m"); 
        $tgl   = date("d"); 
        
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
        return($result);
}
?>
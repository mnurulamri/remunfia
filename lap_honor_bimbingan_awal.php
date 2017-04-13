<?
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

if($bulan == "02" or $bulan == "03" or $bulan == "04" or $bulan == "05" or $bulan == "06" or $bulan == "07"){
	$smt = 2;
	$tahun_akad = $tahun-1;
} else{
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
	$kd_organisasi = $_SESSION['kode'];
}

#setting judul laporan dan header tabel

#setting judul header
$judullaporan = "Laporan Honor Bimbingan dan Insentif Periode $vbulan $tahun";

$_SESSION["judullaporan"] = $judullaporan;
$header = array(	
	array("label"=>"PENGAJAR", "length"=>50, "align"=>"C", "align2"=>"L"),
	array("label"=>"KETERANGAN", "length"=>80, "align"=>"C", "align2"=>"L"),
	array("label"=>"JML", "length"=>15, "align"=>"C", "align2"=>"C"),
	array("label"=>"HARGA SATUAN", "length"=>18, "align"=>"C", "align2"=>"R"),
	array("label"=>"HONOR", "length"=>18, "align"=>"C", "align2"=>"R")
);
 
#sertakan library FPDF dan bentuk objek
require_once ("../remun/fpdf/fpdf.php");

#tampilkan judul laporan
class PDF extends FPDF
{
//Page header
	function Header()
	{		
		$this->Image('images/makara_gold.jpg',15,5,13);
		$this->SetY(6);
		$this->Cell(20);
		$this->SetFont('Arial','B','8');
		$this->Cell(0,4, 'Universitas Indonesia', '0', 1, 'L');
		$this->Cell(20);
		$this->Cell(0,4, 'Fakultas Ilmu Sosial dan Ilmu Politik', '0', 1, 'L');
		$this->Cell(20);
		$this->Cell(0,4, $_SESSION["programstudi"], '0', 1, 'L');
		$this->Ln(4);
		$this->SetFont('Arial','B','9');
		$this->Cell(0,3, $_SESSION["judullaporan"], '0', 1, 'C');
		$this->Ln(2);
		
		#buat header tabel
		$this->SetX(15);
		$this->SetFont('Arial','B','8');
		$this->SetFillColor(215,225,245);
		$this->SetTextColor(0);
		$this->SetDrawColor(238,249,269);
		$this->Cell(50,5, 'NAMA PENGAJAR', 1, 0, 'C', true);
		$this->Cell(80,5, 'KETERANGAN', 1, 0, 'L', true);
		$this->Cell(15,5, 'JML', 1, 0, 'C', true);
		$this->Cell(18,5, 'HARGA SATUAN', 1, 0, 'C', true);
		$this->Cell(18,5, 'HONOR', 1, 1, 'C', true);
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
$pdf->SetX(15);
$pdf->SetFillColor(238,249,269);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(238,249,269);
$pdf->SetFont('Arial','','8');
$fill = false;

#ambil data
$data = array();
if ($username == "admin" or $username == "remunerasifisipui" or $username == "indra"){
  $sql = "SELECT nama_pengajar, jenis_bimbingan, jml_mhs, harga_satuan, honor 
			FROM bimbingan a, pengajar d
			WHERE a.nip = d.nip and a.kd_organisasi = '$kode_prodi' and
				  d.tahun = $tahun and d.bulan = '$bulan' and 
				  a.tahun = d.tahun and a.bulan = d.bulan
			ORDER BY nama_pengajar";
} else {
	$sql = "SELECT nama_pengajar, jenis_bimbingan, jml_mhs, harga_satuan, honor 
			FROM bimbingan a, pengajar d
			WHERE a.nip = d.nip and a.kd_organisasi = '$kd_organisasi' and
				  d.tahun = $tahun and d.bulan = '$bulan' and 
				  a.tahun = d.tahun and a.bulan = d.bulan
			ORDER BY nama_pengajar";
}

$result = mysql_query($sql) or die (mysql_error());
$rows = mysql_num_rows($result);

if($rows > 0){
	$data = "";
	$data = array();
	while ($row = mysql_fetch_object($result)){
		$data[$row->nama_pengajar][] = $row;
	}
	#untuk masing-masing pengajar
	$honor_total = 0;
	
	foreach ($data as $pengajar => $records){
		#tampilkan datanya
		#$pdf->SetFillColor(238,249,269);
		#$pdf->SetTextColor(0);
		#$pdf->SetDrawColor(238,249,269);
		$pdf->SetFont('Arial','','8');
		$fill = false;
		$j = 0;
		$honor = 0;
		
		#$pdf->Cell(35, 5, $pengajar, 1, '1', 'L', $fill);
		foreach ($records as $baris){
			$i = 0;
			#$pdf->Cell(35, 5, $baris->nama_pengajar, 1, '1', 'L', $fill);
			$pdf->SetX(15);
			if($j==0){
				foreach ($baris as $cell) {				
					if($i==3 or $i==4){
						$pdf->SetTextColor(0);
						$pdf->SetFont('Arial','','8');
						$pdf->SetDrawColor(215,225,245);
						$cell = number_format($cell);
						$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
					} else if($i==0){
						$pdf->SetTextColor(88,88,88);
						$pdf->SetFont('Arial','B','8');
						$pdf->SetDrawColor(215,225,245);
						$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
					} else {
						$pdf->SetTextColor(0);
						$pdf->SetFont('Arial','','8');
						$pdf->SetDrawColor(215,225,245);
						$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
					}
					$i++;
				}			
			} else {
				foreach ($baris as $cell) {							
					if($i==3 or $i==4){
						$pdf->SetDrawColor(215,225,245);
						$cell = number_format($cell);
						$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
					} else if($i==0){
						$cell='';						
						$pdf->SetDrawColor(215,225,245);
						$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
					} else {
						$pdf->SetDrawColor(215,225,245);
						$pdf->Cell($header[$i]['length'], 5, $cell, 1, '0', $header[$i]['align2'], $fill);
					}
					$i++;
					
				}
			}
			$honor += $baris->honor;
			$honor_total += $baris->honor;
			$j++;
			#$fill = !$fill;
			
			$pdf->Ln();
			
		}
		$pdf->SetX(15);
		$pdf->SetFont('Arial','B','8');
		$pdf->SetTextColor(88,88,88);
		$pdf->SetDrawColor(215,225,245);
		$pdf->Cell(163, 5, 'Total  ', 1, '0', 'R', $fill);					
		$pdf->Cell(18, 5, number_format($honor), 1, '1', 'R', $fill);
		$pdf->ln();
		
	}
		$pdf->SetX(21);
		$pdf->SetTextColor(88,88,88);
		$pdf->SetDrawColor(238,249,269);
		$pdf->Cell(163, 5, 'Grand Total  ', 1, '0', 'R', true);		
		$pdf->SetFont('Arial','B','8');
		$pdf->Cell(18, 5, number_format($honor_total), 1, '1', 'R', true);
		$pdf->ln();

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
	} else if ($_SESSION['programstudi'] == "Program Magister Ilmu Komunikasi"){
		#Sign Ketua Program
		$pdf->ln(50);
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
	} else if ($_SESSION['programstudi'] == "Program Magister Ilmu Politik"){
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
	} else {
		#Sign Ketua Program
		$tanggal = "Depok, ".date("j")." ".$vbulan." ".$tahun;
		$pdf->SetFont('Arial','B','8');
		$pdf->Ln(8);
		$pdf->Cell(100);
		$pdf->Cell(0,4, $tanggal, '0', 1, 'L');
		$pdf->Cell(100);
		$pdf->Cell(0,4, 'Mengetahui,', '0', 1, 'L');
		$pdf->Cell(100);
		$pdf->Cell(0,4, 'Ketua '.$_SESSION['programstudi'], '0', 1, 'L');
		$pdf->Ln(15);
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
?>
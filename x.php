<?php
#setting session, hadir aktual, tahun dan bulan
session_start();
/*$username = $_SESSION["username"];
$tahun = $_POST["tahun"];
$vbulan = $_POST["bulan"];
*/
$username = "kessos";
$tahun = 2014;
$vbulan = "Juli";

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

$ta = "Universitas Indonesia\nFakultas Ilmu Sosial dan Ilmu Politik\nProgram Studi...";
$title = "Laporan Honor Bimbingan dan Insentif Periode $vbulan $tahun";

// Include the main TCPDF library (search for installation path).
require_once('/var/www/ppaa.fisip.ui.ac.id/html/tcpdf/tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		$tahun = $_POST["tahun"];
		$vbulan = $_POST["bulan"];
		$title = "Laporan Honor Bimbingan dan Insentif Periode $vbulan $tahun";
		$kd_organisasi = "06.01.09.01";
		// Logo
		$image_file = 'images/makara_gold.jpg';		
		$this->Image($image_file, 10, 5, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);//(file,x,y,w,h,type,link,align,resize,dpi,palign,ismask,imgmask,border,fitbox,hidden,fitonpage,alt,altimgs)
		// Set font
		$this->SetFont('helvetica', '', 10);
		// Title
		$this->SetXY(30,8);
		$this->Cell(0, 8, 'Universitas Indonesia', 0, true, 'L', 0, '', 0, false, 'M', 'M'); //(width,height,text,border,ln,align,fill,link,stretch,ignore_min_height,calign,valign)
		$this->SetX(30);
		$this->Cell(0, 8, 'Fakultas Ilmu Sosial dan Ilmu Politik', 0, true, 'L', 0, '', 0, false, 'M', 'M');
		$this->SetX(30);
		$this->Cell(0, 8, $_SESSION["programstudi"], 0, true, 'L', 0, '', 0, false, 'M', 'M');
		$this->Ln(2);
		$this->Cell(0, 8, $title, 0, true, 'C', 0, '', 0, false, 'M', 'M');
	}

	public function MultiRow($left, $right) {
		// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0)

		$page_start = $this->getPage();
		$y_start = $this->GetY();

		// write the left cell
		$this->MultiCell(40, 0, $left, 1, 'R', 1, 2, '', '', true, 0);

		$page_end_1 = $this->getPage();
		$y_end_1 = $this->GetY();

		$this->setPage($page_start);

		// write the right cell
		$this->MultiCell(0, 0, $right, 1, 'J', 0, 1, $this->GetX() ,$y_start, true, 0);

		$page_end_2 = $this->getPage();
		$y_end_2 = $this->GetY();

		// set the new row position by case
		if (max($page_end_1,$page_end_2) == $page_start) {
			$ynew = max($y_end_1, $y_end_2);
		} elseif ($page_end_1 == $page_end_2) {
			$ynew = max($y_end_1, $y_end_2);
		} elseif ($page_end_1 > $page_end_2) {
			$ynew = $y_end_1;
		} else {
			$ynew = $y_end_2;
		}

		$this->setPage(max($page_end_1,$page_end_2));
		$this->SetXY($this->GetX(),$ynew);
	}

}

// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Muhammad Nuurul Amri');
$pdf->SetTitle('Laporan Bimbingan dan Insentif');
$pdf->SetSubject('Semester');
$pdf->SetKeywords('TCPDF, PDF, ujian, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 020', PDF_HEADER_STRING);
//$pdf->SetHeaderData('', '', $title, $ta);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetHeaderMargin('10');

//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetFooterMargin('10');

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 20);
// add a page
$pdf->AddPage();

$pdf->Write(0, '', '', 0, 'C', true, 0, false, false, 0);

$pdf->Ln(-8);

$pdf->SetFont('helvetica', '', 9);

//$pdf->SetCellPadding(0);
//$pdf->SetLineWidth(2);

// set color for background
$pdf->SetFillColor(255, 255, 200);

include("conn.php"); 

//ambil database
$query = "SELECT nama_pengajar, jenis_bimbingan, jml_mhs, harga_satuan, honor 
		FROM bimbingan a, pengajar d
		WHERE a.nip = d.nip and a.kd_organisasi = '$kd_organisasi' and
			  d.tahun = $tahun and d.bulan = '$bulan' and 
			  a.tahun = d.tahun and a.bulan = d.bulan
		ORDER BY nama_pengajar";

$result = mysql_query($query) or die();
$data = array();
while($row = mysql_fetch_object($result)){
	$data[$row->nama_pengajar][] = $row;
}
$grand_total = 0;
$html = '<table style="border-collapse:collapse; font-family:arial;">';
$html.= '<thead>';
$html.= '<tr style="background-color:gray; border:1px solid gray; font-weight:bold; font-size:12px; color:#fff; text-align:center"><td style="width:30%;  border-right:1px solid #fff;">Nama Pengajar</td><td style="border-right:1px solid #fff;width:40%">Keterangan</td><td style="border-right:1px solid #fff; width:15%;">Harga Satuan</td><td style="border-right:1px solid #fff;width:5%;">Jml</td><td style="border:1px solid gray;width:10%">Honor</td></tr>';
$html.= '</thead>';
$html.= '<tbody>';
$html.= '<tr><td colspan="5" style="border-left:1px solid #fff;border-right:1px solid #fff;"></td></tr>';
foreach($data as $pengajar => $records){
	$j = 0; //setting flag nomor baris untuk merge2an
	$honor = 0;	
	
	
	foreach($records as $baris){
		$honor += $baris->honor;
		$grand_total += $baris->honor;
		$html.='<tr style="border:1px solid gray">';
				
		if($j==0){
			//jika berada pada posisi baris pertama untuk masing2 record pengajar maka isi nama pengajar
			$html.= '<td style="border-left:1px solid gray;border-top:1px solid gray; width:30%">'.$baris->nama_pengajar.'</td>';
		} else {
			//jika berada pada posisi setelah baris pertama untuk masing2 record pengajar maka kosongkan nama pengajar
			$html.= '<td style="border-left:1px solid gray;width:30%">&nbsp;</td>';
		}
		
		$html.= '<td style="border-top:1px solid gray; border-left:1px solid gray;border-bottom:1px solid gray;width:40%">'.$baris->jenis_bimbingan.'</td>';
		$html.= '<td style="border-top:1px solid gray; border-bottom:1px solid gray;width:15%; text-align:right">'.$baris->harga_satuan.'</td>';
		$html.= '<td style="border-top:1px solid gray; border-bottom:1px solid gray;width:5%; text-align:center">'.$baris->jml_mhs.'</td>';
		$html.= '<td style="border-top:1px solid gray; border-bottom:1px solid gray;border-right:1px solid gray;text-align:right;width:10%">'.number_format($baris->honor).'</td>';
		$html.= '</tr>';
		
		//buat mancing doang...
		$i=0;

		$j=$j+1;
	}
		//tentukan total honor masing2 pengajar
		$html.= '<tr style="font-weight:bold;"><td style="border-top:1px solid gray;text-align:right;color:gray" colspan="4">Total</td><td style="border:1px solid gray;text-align:right;">'.number_format($honor).'</td></tr>';
		
		$html.= '<tr><td colspan="5"></td></tr>';
}

$html.= '<tr style="font-weight:bold;"><td style="border:1px solid gray;background-color:gray;text-align:right; font-weight:bold; font-size:12px; color:#fff" colspan="3">Grand Total</td><td colspan="2" style="border:1px solid gray;text-align:right;">'.number_format($grand_total).'</td></tr>';
$html.= '</tbody></table>';
$html.= '<br><br>';
$html.= '<table>';
$html.= '<tr nobr="true"><td style="width:60%;"></td><td style="width:40%; font-weight:bold;">Depok, '.DateToIndo().'<br>Mengetahui,<br>Ketua '.$_SESSION['programstudi'].'<br><br><br>'.$_SESSION['ketuaprogram'].'<br>NIP/NUP: '.$_SESSION['nip'].'</td></tr>';
$html.= '</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Sign Ketua Program
$tanggal = "Depok, ".DateToIndo();
$pdf->SetFont('Helvetica','B','10');
$pdf->Ln(8);
$pdf->Cell(100);
$pdf->Cell(0,4, $tanggal, '0', 1, 'L');
$pdf->Cell(100);
$pdf->Cell(0,4, 'Mengetahui,', '0', 1, 'L');
$pdf->Cell(100);
//$pdf->MultiCell(0,4, 'Ketua '.$_SESSION['programstudi'], '0', 1, 'L');
$pdf->MultiCell(0,4, 'Ketua '.$_SESSION['programstudi'], 0, 'L', 0, 1, '', '', true);
$pdf->Ln(15);
$pdf->Cell(100);
$pdf->Cell(0,4, $_SESSION['ketuaprogram'], '0', 1, 'L');
$pdf->Cell(100);
$pdf->Cell(0,4, 'NIP/NUP: '.$_SESSION['nip'], '0', 1, 'L');	

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('lap-bimbingan-insentif.pdf', 'I');

//kembalikan session untuk admin
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

function DateToIndo() { // fungsi atau method untuk mengubah tanggal ke format indonesia
   // variabel BulanIndo merupakan variabel array yang menyimpan nama-nama bulan
        $BulanIndo = array("Januari", "Februari", "Maret",
                           "April", "Mei", "Juni",
                           "Juli", "Agustus", "September",
                           "Oktober", "November", "Desember");
    
        $tahun = date("Y"); // memisahkan format tahun menggunakan substring
        $bulan = date("m"); // memisahkan format bulan menggunakan substring
        $tgl   = date("d"); // memisahkan format tanggal menggunakan substring
        
        $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
        return($result);
}
//============================================================+
// END OF FILE
//============================================================+
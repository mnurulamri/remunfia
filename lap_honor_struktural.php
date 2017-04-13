<?
if(!session_id()) session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username'])) header("Location:index.php");
include 'conn.php';

$tahun = $_POST['tahun'];
$bulan = $_POST['bulan'];
$dept_arr = array('01'=>'Ilmu Komunikasi', '02'=>'Ilmu Politik', '03'=>'Ilmu Adminsitrasi', '04'=>'Sosiologi',
				  '05'=>'Kriminologi', '06'=>'Ilmu Kesejahteraan Sosial', '07'=>'Antropologi', '08'=>'Ilmu Hubungan Internasional');
				  						 
if($_SESSION['hak_akses']=='1'){
	//set kode program studi
	$kd_organisasi = $_POST['kode'];
	//set nama ketua departemen
	$hasil = mysql_query("SELECT nip, nama FROM pejabat_departemen WHERE kd_dep = substr('$kd_organisasi',4,2)");
	while($row = mysql_fetch_object($hasil)){
		$ketua_departemen = $row->nama;
		if(strlen($row->nip)>15){
			$nip_dept = 'NIP. '.$row->nip;
		} else {
			$nip_dept = 'NUP. '.$row->nip;
		}	
	}	
	//set nama program studi	
	$result = mysql_query("SELECT nip, ketuaprogramstudi, programstudi FROM organisasi WHERE kodeorganisasi='$kd_organisasi'");
	while($row = mysql_fetch_object($result)){
		$nama_prodi = $row->programstudi;
		$ketua_prodi = $row->ketuaprogramstudi;
		if(strlen($row->nip)>15){
			$nip_prodi = 'NIP. '.$row->nip;
		} else {
			$nip_prodi = 'NUP. '.$row->nip;
		}	
	}
	//set Departemen
	$departemen = $dept_arr[substr($kd_organisasi,3,2)];
} else {
	//set kode program studi
	$kd_organisasi = $_POST['kode'];
	//set nama ketua departemen
	$hasil = mysql_query("SELECT nip, nama FROM pejabat_departemen WHERE kd_dep = substr('$kd_organisasi',4,2)");
	while($row = mysql_fetch_object($hasil)){
		$ketua_departemen = $row->nama;
		if(strlen($row->nip)>15){
			$nip_dept = 'NIP. '.$row->nip;
		} else {
			$nip_dept = 'NUP. '.$row->nip;
		}	
	}
	
	//set nama program studi
	$nama_prodi = $_SESSION["programstudi"];
	$ketua_prodi = $_SESSION["ketuaprogramstudi"];
	if(strlen($_SESSION["nip"])>15){
		$nip_prodi = 'NIP. '.$row->nip;
	} else {
		$nip_prodi = 'NUP. '.$row->nip;
	}	
	// set Departemen
	$departemen = $dept_arr[substr($kd_organisasi,3,2)];
}

//set bulan
$bulan_arr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$nama_bulan = $bulan_arr[$bulan];
	
// Include the main TCPDF library (search for installation path).
require_once('/home/ppaa/public_html/tcpdf/tcpdf_include.php');  //require_once('../../tcpdf/tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {

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
$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);  //(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Muhammad Nuurul Amri');
$pdf->SetTitle('Tunjangan Struktural');
$pdf->SetSubject('Semester');
$pdf->SetKeywords('TCPDF, PDF, ujian, test, guide');
//$pdf->SetHeaderData('', '', $title, $ta);  //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 020', PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN)); // set header and footer fonts
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font
$pdf->SetMargins('20', '35', '7');  //set margins (LEFT, TOP, RIGHT)
$pdf->SetHeaderMargin('20'); //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin('15'); //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); // set auto page breaks
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); // set image scale factor

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

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
//$pdf->Ln(-8);

$pdf->SetFont('helvetica', '', 10);

//$pdf->SetCellPadding(0);
//$pdf->SetLineWidth(2);

// set color for background
//$pdf->SetFillColor(255, 255, 200);

// set surat pengantar
$txt = 'Depok, '.DateToIndo();
$pdf->Write(0, $txt, '', 0, 'R', true, 0, false, false, 0);

$head = '
<table border="0">
	<tr>
		<td style="width:5%">No</td>
		<td style="width:1%">:</td>
		<td style="width:40%">&nbsp;</td>
	</tr>
	<tr>
		<td style="width:5%">Lamp</td>
		<td style="width:1%">:</td>
		<td style="width:40%">&nbsp;</td>
	</tr>
	<tr>
		<td>Hal</td>
		<td>:</td>
		<td style="width:40%">Permohonan Pembayaran Tunjangan Struktural</td>
	</tr>
</table>
';
$pdf->writeHTML($head, true, false, true, true, '');

$txt = <<<EOD


Yth. Wakil Dekan
Bidang Sumber Daya, Ventura dan Umum
Dr. Titi Muswati Putranti, M.Si.
FISIP UI
Depok


Bersama ini kami ajukan permohonan pembayaran tunjangan struktural  
EOD;
$txt .= $nama_prodi;
$txt .= ' periode '.$nama_bulan.' '.$tahun;

$txt .= <<<EOD
 dengan rincian sebagai berikut:


EOD;
// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

//ambil data dari database
$sql = "SELECT c.id as id, a.nip as nip, a.jabatan as jabatan, c.tunjangan as tunjangan, a.no_sk as no_sk,  a.tgl_awal as tgl_awal, a.tgl_akhir as tgl_akhir, b.nama_pengajar as nama_pengajar
		FROM struktural a, master_pengajar b, struktural_trans c
		WHERE a.nip = b.nip AND a.nip = c.nip AND c.tahun = '$tahun' AND c.bulan = '$bulan' AND YEAR(tgl_akhir) >= $tahun AND MONTH(tgl_akhir) >= '$bulan' AND c.kd_organisasi = '$kd_organisasi'";
$result = mysql_query($sql) or die();
$row_number = mysql_num_rows($result);
if($row_number==0){
	echo "
	<script language='JavaScript'>
		alert('Tidak Ada Data');
		document.location='lap_struktural_interface.php';
	</script>
	";
}

$counter = 0;
$total = 0;
//$pdf->SetCellPaddings('2','0','0','0');
$pdf->SetCellPaddings(1,1,1,1); //left, top, bottom, right
$html = '
<style>
table {border-collapse:collapse; width:100%}
.col-row {font-weight:bold; background-color:#000; border-left:1px solid #000; }
.col-head {text-align:center; color:white;}
td {border:1px solid gray; border-bottom:1px solid #000;}
.col-nip {width:12%; border-left:1px solid #000}
.col-nama {width:20%;}
.col-jab {width:23%;}
.col-tunj {width:12%; text-align:right;}
.col-sk {width:15%;}
.col-berlaku {width:19%; text-align:center; border-right:1px solid #000;}

</style>

<table>
	<thead>
		<tr class="col-row">
			<th class="col-head" style="width:12%; border-top:1px solid #000; border-left:1px solid #000; line-height:10px">NIP</th>
			<th class="col-head" style="width:20%; border-top:1px solid #000; line-height:10px">Nama Pengajar</th>
			<th class="col-head" style="width:23%; border-top:1px solid #000; line-height:10px">Jabatan</th>
			<th class="col-head" style="width:12%; border-top:1px solid #000; line-height:10px">Tunjangan</th>
			<th class="col-head" style="width:15%; border-top:1px solid #000; line-height:10px">Nomor SK</th>
			<th class="col-head" style="width:19%; border-top:1px solid #000; border-right:1px solid #000; line-height:10px">Berlaku</th>
		</tr>	
	</thead>
	<tbody>';

while($row = mysql_fetch_object($result)) {
	if ($row->tgl_awal == "0000-00-00"){$tgl_awal = "2014-10-01"; $tgl_akhir="2014-12-30";} else {$tgl_awal = $row->tgl_awal; $tgl_akhir = $row->tgl_akhir;}
	//$tgl_awal_arr = explode("-", $row->tgl_awal);
	$tgl_awal_arr = explode("-", $tgl_awal);
	//$n = $tgl_awal_arr[1];
	$m_awal = $bulan_arr[$tgl_awal_arr[1]];
	$tgl_awal = $tgl_awal_arr[2].' '.$m_awal.' '.$tgl_awal_arr[0];
	
	//$tgl_akhir_arr = explode("-", $row->tgl_akhir);
	$tgl_akhir_arr = explode("-", $tgl_akhir);
	//$n = $tgl_awal_arr[1];
	$m_akhir = $bulan_arr[$tgl_akhir_arr[1]];
	$tgl_akhir = $tgl_akhir_arr[2].' '.$m_akhir.' '.$tgl_akhir_arr[0];
	
    $html.= '
		<tr nobr="true">
			<td id="nip_'.$row->id.'" class="col-nip">'.$row->nip.'</td>
			<td id="nama_pengajar_'.$row->id.'" class="col-nama">'.$row->nama_pengajar.'</td>
			<td id="jabatan_'.$row->id.'" class="col-jab">'.$row->jabatan.'</td>
			<td id="tunjangan_'.$row->id.'" class="col-tunj">'.number_format($row->tunjangan).'</td>
			<td id="no_sk_'.$row->id.'" class="col-sk">'.$row->no_sk.'</td>
			<td id="berlaku_'.$row->id.'" class="col-berlaku">'.$tgl_akhir.'</td>
		</tr>';
	$counter += 1;
	$total += $row->tunjangan;
}

$html.= '
		<tr style="font-weight:bold;">
			<td style="border-left:1px solid white; border-bottom:1px solid white; text-align:right; padding-right:6px;" colspan="3">Total</td>
			<td style="border:1px solid #000; text-align:right; background-color:lightgray;">'.number_format($total).'</td>
			<td style="border-right:1px solid white; border-bottom:1px solid white;" colspan="2"></td>
		</tr>
	</tbody>
</table>';

$pdf->writeHTML($html, true, false, true, true, '');

// set surat pengantar
$txt = <<<EOD
Terbilang: 
EOD;
$txt .= str_replace("  "," ",Terbilang($total));
$txt .= <<<EOD
 rupiah.
 
Berkaitan dengan hal tersebut, kami mohon agar dapat diproses sesuai dengan data terlampir.
Terima kasih atas perhatian dan kerja sama Bapak


EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

//kolom tanda tangan pengesahan
$ttd = '
<table style="width:100%" border="0">
	<tr>
		<td style="width:60%">
			Mengetahui,<br>
			Ketua Departemen<br>
			'.$departemen.'<br>
			<br>
			<br>
			<br>
			'.$ketua_departemen.'<br>
			'.$nip_dept.'
		</td>
		<td style="width:40%">
			&nbsp;<br>
			Ketua '.str_replace($departemen,"",$nama_prodi).'<br>
			'.$departemen.'<br>
			<br>
			<br>
			<br>
			'.$ketua_prodi.'<br>
			'.$nip_prodi.'
		</td>
	</tr>
	<!--<tr>
		<td colspan="3" style="text-align:center">
			Menyetujui,<br>
			Wakil Dekan Bidang Sumber Daya, Ventura dan Umum<br>
			<br>
			<br>
			<br>

		</td>		
	</tr>
	<tr>
		<td style="width:39%">&nbsp;</td>
		<td style="width:61%">
			Dr. Titi Muswati Putranti, M.Si.<br>
			NIP. 196108111989032001		
		</td>
	</tr>
</table>-->
';
$pdf->writeHTML($ttd, true, false, true, true, '');

// reset pointer to the last page
$pdf->lastPage();

//Close and output PDF document
$pdf->Output('lap_tunjangan_struktural.pdf', 'I');

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

//fungsi terbilang
function Terbilang($x)
{
  $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "Belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " Seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " Seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
}
?>
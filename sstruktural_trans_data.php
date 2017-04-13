<!--
file ini untuk menggenerate tabel pengajuan honor tiap bulan
berisi informasi pengajuan honor berdasarkan data yang telah diinputkan sebelumnya pada tabel master struktural yang berisi nomor SK dkk.
namun demikian user tetap dapat merubah tunjangan honor pada tiap bulan yang berjalan


<link href="css/table.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.js"></script>-->
<script>
$(document).ready(function(){
	$('table tbody tr').hide();
});

function detail(kode){
	var selector = '.' + kode;
	$('.'+kode).toggle();
}
</script>

<?
if(!session_id()) session_start();
/*$username = $_SESSION["username"];
if(!isset($_SESSION['username']) || empty($_SESSION['username']) || $_SESSION['hak_akses']!=3) header("Location:index.php");
$nip = $_SESSION["nip"];*/

include ('conn.php');
//include("menu.php");

//setting kode program studi, tahun dan bulan -> jika tahun dan bulan belum di set maka setting tahun dan bulan saat ini
$cur_year = date('Y');
$cur_month = date('m');
if (!isset($_POST['tahun'])) {$tahun = $cur_year;} else {$tahun = $_POST['tahun'];}
if (!isset($_POST['bulan'])) {$bulan = $cur_month;} else {$bulan = $_POST['bulan'];}

//query untuk mengambil data pengajuan honor tiap bulan
$sql_trans = "SELECT program, prodi, c.id as id, a.nip as nip, a.jabatan as jabatan, c.tunjangan as tunjangan, a.no_sk as no_sk, a.tgl_akhir as tgl_akhir, b.nama_pengajar as nama_pengajar
		FROM struktural a, master_pengajar b, struktural_trans c, organisasi d
		WHERE a.nip = b.nip AND 
			  a.nip = c.nip AND 
			  b.nip = c.nip AND 
			  c.tahun = '$tahun' AND 
			  c.bulan = '$bulan' AND 
			  YEAR(tgl_akhir) >= $tahun AND 
			  MONTH(tgl_akhir) >= '$bulan' AND  
			  a.kd_organisasi = kodeorganisasi";
$result_trans = mysql_query($sql_trans) or die(mysql_error());	
$rownumber = mysql_num_rows($result_trans);

//masukkan datake dalam array 
$data = array();
while ($row = mysql_fetch_object($result_trans)){
	$data[$row->program][$row->prodi][] = $row;
}



echo '
<div class="msg_list" style="width:80%">
	<div style="font-size:0.7em; font-family:verdana;">';
	$grand_total = 0;
//proses cetak tunjangan untuk masing-masing program studi	
foreach($data as $kProgram => $dProdi){

	//inisialisasi grand total prodi

	
	foreach ($dProdi as $kProdi => $vProdi){
		//inisialisasi id
		$kode = $kProgram.$kProdi;
		$kode = str_replace(" ","",$kode);
		
		//menghitung total tunjangan per prodi
		$total = 0;
		foreach($vProdi as $tot){
			$total+=$tot->tunjangan;
		}
		
		//cetak header table
		echo '
		<table style="width:100%;">
			<thead>
				<tr class="head" style="line-height:12px; line-height:25px; padding-left:20px; font-size:11px; cursor:pointer" onclick="detail(\''.$kode.'\')">
					<th class="table-head-cell" style="width:65%;" colspan="3">'.$kProgram.' '.$kProdi.'</th>
					<th class="table-head-cell" style="width:10%; text-align:right" id="t_'.$kode.'">'.number_format($total).'</th>
					<th class="table-head-cell" style="width:28%;" colspan="2">&nbsp;</th>
				</tr>	
			</thead>
			<tbody>
				<tr class="'.$kode.'" style="line-height:12px; line-height:25px; padding-left:20px; font-size:11px; background-color:lightgray; color:white; font-weight:bold">
					<td style="width:15%; text-align:center;">NIP</td>
					<td style="width:20%; text-align:center;">Nama</td>
					<td style="width:30%; text-align:center;">Jabatan</td>
					<td style="width:10%; text-align:center;">Tunjangan</td>
					<td style="width:12%; text-align:center;">Nomor SK</td>
					<td style="width:16%; text-align:center;">Berlaku</td>
				</tr>';
		
		//cetak data
		foreach($vProdi as $cell){
		
			//konversi tgl berlaku ke format indonesia
			$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
			$tgl_akhir_arr = explode("-", $cell->tgl_akhir);
			$m_akhir = $bulan[$tgl_akhir_arr[1]];
			$tgl_akhir = $tgl_akhir_arr[2].' '.$m_akhir.' '.$tgl_akhir_arr[0];
			
			echo'
				<tr class="'.$kode.'" style="line-height:12px; line-height:25px; padding-left:20px; font-size:11px;">
					<td style="width:150px;">'.$cell->nip.'</td>
					<td style="width:20%;">'.$cell->nama_pengajar.'</td>
					<td style="width:30%;">'.$cell->jabatan.'</td>
					<td style="width:10%; text-align:right">'.number_format($cell->tunjangan).'</td>
					<td style="width:12%;">'.$cell->no_sk.'</td>
					<td style="width:16%;">'.$tgl_akhir.'</td>
				</tr>';
			$grand_total+=$cell->tunjangan;
		}		
		echo'
			</tbody>
		</table>';					
	}
}
echo'
		<table style="width:100%;">
			<tfoot>
				<tr style="line-height:12px; line-height:25px; padding-left:20px; font-size:11px; background-color:gold">
					<th style="width:65%;" colspan="3">Total</th>
					<th style="width:10%; text-align:right">'.number_format($grand_total).'</th>
					<th style="width:28%;" colspan="2">&nbsp;</th>
				</tr>	
			</tfoot>
		</table>
	</div>
</div>';
?>
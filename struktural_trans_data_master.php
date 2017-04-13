<?
/*
modul ini untuk menginput data transaksi struktural per periode (per tahun per bulan) yang datanya di ambil dari master data struktural
informasi yang dihasilkan pada modul ini hanya memuat data yang sebelumnya sudah diinputkan ke dalam data master struktural, 
jadi sebagai filter agar user tidak bisa menginput data transaksi per bulan yang master data strukturalnya belum terisi 
*/

if(!session_id()) session_start();
$username = $_SESSION["username"];
if(!isset($_SESSION['username']) || empty($_SESSION['username']))	header("Location:index.php");

include 'conn.php';

//setting kode program studi, tahun dan bulan -> jika tahun dan bulan belum di set maka setting tahun dan bulan saat ini
$kd_organisasi = $_SESSION['kode'];
$cur_year = date('Y');
$cur_month = date('m');
if (!isset($_POST['tahun'])) {$tahun = $cur_year;} else {$tahun = $_POST['tahun'];}
if (!isset($_POST['bulan'])) {$bulan = $cur_month;} else {$bulan = $_POST['bulan'];}

//ambil data dari database untuk menampilkan data master struktural berdasarkan program studi
$sql_induk = "SELECT a.*, b.nama_pengajar as nama_pengajar
		FROM struktural a, master_pengajar b
		WHERE a.nip = b.nip and YEAR(tgl_akhir) >= $tahun AND MONTH(tgl_akhir) >= '$bulan' AND kd_organisasi = '$kd_organisasi'";

$result_induk = mysql_query($sql_induk) or die(mysql_error());

$data = array();
while ($row = mysql_fetch_object($result_induk)){
	$data[] = $row;
}
?>

<!-- script untuk ngerapiin tabel --> 
<script>
$(document).ready(function() {
    // DataTable
    var table = $('#data_master').DataTable();
} );
</script>

<?
//buat nama kolom tabel
echo '
<!--<input type="text" name="tahun" id="tahun" value="'.$tahun.'"/>
<input type="text" name="bulan" id="bulan" value="'.$bulan.'"/>-->
<div>
<table id="data_master" class="display" width="100%">
	<thead>
		<tr style="background-color:#571B7E;color:white">
			<th>Id</th><th>Nip</th><th>Nama</th><th>Jabatan</th><th>Tunjangan</th><th>Nomor SK</th><th>Berlaku</th>
		</tr>
	</thead>
	<tbody>';

//isi tabel	
$no = 1;
foreach ($data as $row){  //tampilkan data struktural per bulan

	//konversi tanggal format indonesia
	$tgl_akhir_arr = explode("-", $row->tgl_akhir);
	$bulan_arr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	//$n = $tgl_awal_arr[1];
	$m_akhir = $bulan_arr[$tgl_akhir_arr[1]];
	$tgl_akhir = $tgl_akhir_arr[2].' '.$m_akhir.' '.$tgl_akhir_arr[0];
	
	echo '
		<tr style="font-weight:bold; color:#894db0; font-family:arial; cursor:pointer;" onclick="tambah('.$row->id.','.$tahun.','.$bulan.',\''.$row->nip.'\','.$row->tunjangan.')">
			<td style="width:3%">'.$row->id.'</td>
			<td id="nip_'.$row->id.'" style="width:10%">'.$row->nip.'</td>
			<td id="nama_pengajar_'.$row->id.'" style="width:18%">'.$row->nama_pengajar.'</td>
			<td id="jabatan_'.$row->id.'" style="width:22%">'.$row->jabatan.'</td>
			<td id="tunjangan_'.$row->id.'" style="text-align:right;" value="'.number_format($row->tunjangan).'"</td>
			<td id="no_sk_'.$row->id.'" style="width:20%">'.$row->no_sk.'</td>
			<td id="tgl_akhir_'.$row->id.'" style="width:12%">'.$tgl_akhir.'</td>
		</tr>
	';
	$no++;
}
echo '
	</tbody>
</table>
</div>'; 	
?>
<?
/* 
file ini untuk menggenerate tabel pengajuan honor tiap bulan
pengajuan honor berdasarkan data yang telah diinputkan sebelumnya pada tabel master struktural yang berisi nomor SK dkk.
namun demikian user tetap dapat merubah tunjangan honor pada tiap bulan yang berjalan
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

//query untuk mengambil data master struktural
$sql_induk = "SELECT a.*, b.nama_pengajar as nama_pengajar
		FROM struktural a, master_pengajar b
		WHERE a.nip = b.nip AND YEAR(tgl_akhir) >= $tahun AND MONTH(tgl_akhir) >= '$bulan' and kd_organisasi = '$kd_organisasi'";
$result_induk = mysql_query($sql_induk);

//query untuk mengambil data pengajuan honor tiap bulan
$sql_trans = "SELECT a.nip as nip, a.jabatan as jabatan, c.tunjangan as tunjangan, a.no_sk as no_sk, a.tgl_akhir as tgl_akhir, b.nama_pengajar as nama_pengajar
		FROM struktural a, master_pengajar b, struktural_trans c
		WHERE a.nip = b.nip AND a.nip = c.nip AND c.tahun = '$tahun' AND c.bulan = '$bulan' AND YEAR(tgl_akhir) >= $tahun AND MONTH(tgl_akhir) >= '$bulan' AND c.kd_organisasi = '$kd_organisasi'";
$result_trans = mysql_query($sql_trans) or die(mysql_error());
$rownumber = mysql_num_rows($result_trans);

echo '</br>';

//masukkan data master struktural ke dalam array untuk persiapan input otomatis pengajuan honor per bulan 
$data = array();
while ($row = mysql_fetch_object($result_induk)){
	$data[] = $row;
}

//jika tabel struktural_trans masih kosong maka secara otomatis akan menginput data berdasarkan data master struktural dengan filter tahun dan bulan
if($rownumber == 0){  	
	foreach($data as $k=>$v){
		$nip = $v->nip;
		$tunjangan = $v->tunjangan;
		$sql = "INSERT INTO struktural_trans (tahun, bulan, kd_organisasi,nip,tunjangan)
				VALUES('$tahun','$bulan','$kd_organisasi','$nip','$tunjangan')";
		$result = mysql_query($sql) or die(mysql_error());
	}
}

	//tark data pengajuan honor struktural per bulan untuk merefresh tabel
	$sql_trans = "SELECT c.id as id, a.nip as nip, a.jabatan as jabatan, c.tunjangan as tunjangan, a.no_sk as no_sk, a.tgl_akhir as tgl_akhir, b.nama_pengajar as nama_pengajar
			FROM struktural a, master_pengajar b, struktural_trans c
			WHERE a.nip = b.nip and a.nip = c.nip and b.nip=c.nip and c.tahun = '$tahun' AND c.bulan = '$bulan' and YEAR(tgl_akhir) >= $tahun AND MONTH(tgl_akhir) >= '$bulan' AND c.kd_organisasi = '$kd_organisasi'";
	$result_trans = mysql_query($sql_trans) or die(mysql_error());	
?>

<!-- script ngerapiin tabel -->
<script>
$(document).ready(function() {
    // DataTable
    var table = $('#dg').DataTable();
} );
</script>
<?
//sett nama kolom tabel pengajuan honor tiap bulan
echo '
<div style="font-size:0.7em; font-family:verdana;">
<table id="dg" class="display" width="100%">
	<thead>
		<tr class="ui-widget-header">
			<th>Id</th><th>del</th><th>Nip</th><th>Nama</th><th>Jabatan</th><th>Tunjangan</th><th>Nomor SK</th><th>Berlaku</th>
		</tr>
	</thead>
	<tbody>';

//isi tabel	
$no = 1;
while ($row = mysql_fetch_object($result_trans)){  //tampilkan data pengajuan honor struktural tiap bulan

	//konversi tanggal ke dalam format indonesia
	$tgl_akhir_arr = explode("-", $row->tgl_akhir);
	$bulan_arr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	$m_akhir = $bulan_arr[$tgl_akhir_arr[1]];
	$tgl_akhir = $tgl_akhir_arr[2].' '.$m_akhir.' '.$tgl_akhir_arr[0];
	
	//tampilkan isi tabel
	echo '
		<tr style="font-weight:bold; color:#3A715E; font-family:arial">
			<td>'.$row->id.'</td>
			<td class="del" style="width:5%">
				<a class="ui-icon ui-icon-trash" onclick="del('.$row->id.');"></a>
			</td>
			<td id="nip_'.$row->id.'" style="width:10%">'.$row->nip.'</td>
			<td id="nama_pengajar_'.$row->id.'" style="width:18%">'.$row->nama_pengajar.'</td>
			<td id="jabatan_'.$row->id.'" style="width:22%">'.$row->jabatan.'</td>
			<td><input type="text" name="tunjangan" id="tunjangan_'.$row->id.'" style="text-align:right;" value="'.number_format($row->tunjangan).'" size="12" onClick="this.select(); init(this.value);" onkeyup="format_uang(this.value,'.$row->id.')" onblur="if(document.getElementById(\'flag\').value==0) this.value=document.getElementById(\'temp\').value" onkeypress="if(event.keyCode==13){document.getElementById(\'flag\').value = 1; edit('.$row->id.',this.value);}"/></td>
			<td id="no_sk_'.$row->id.'" style="width:20%">'.$row->no_sk.'</td>
			<td id="tgl_akhir_'.$row->id.'" style="width:10%">'.$tgl_akhir.'</td>
		</tr>
	';
	$no++;
}
echo '
	</tbody>
	<tr>
		<td class="footer">
			<a href="#" onclick="view_data_master()" class="tooltip"><span>tambah data</span>
				<font class="ui-icon ui-icon-circle-plus"></font>
			</a>
		</td>
		<td colspan="8" class="footer">&nbsp;</td>
	</tr>
</table>
<input type="hidden" id="temp"/><input type="hidden" id="flag" value="0"/>
</div>'; 
?>
</table>
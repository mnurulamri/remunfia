<? 
if(!session_id()) session_start();
if(!isset($_SESSION['username']) || empty($_SESSION['username']))	header("Location:index.php");
$username = $_SESSION["username"];
$kd_organisasi 	= $_SESSION['kd_organisasi'];
?>

<script>
$(document).ready(function() {
    // DataTable
    var table = $('#dg').DataTable();
} );
</script>
<?
include('conn.php');
//include('layout-header-nav.php');

$sql = "SELECT id,a.nip,nama_pengajar, jabatan, tunjangan, no_sk, tgl_awal, tgl_akhir
		FROM struktural a, master_pengajar b
		WHERE a.nip = b.nip and kd_organisasi = '$kd_organisasi'
		ORDER by id desc";
$result = mysql_query($sql);

// Print the column names as the headers of a table
echo '
<div style="font-size:0.7em; font-family:verdana;">
<table id="dg" class="display" width="100%">
	<thead>
		<tr class="ui-widget-header">
			<th>No</th><th>Id</th><th>NIP/NUP</th><th>Nama</th><th>Jabatan</th><th>Tunjangan</th><th>Nomor SK</th><th>Ditetapkan</th><th>Berlaku</th>
		</tr>
	</thead>';

// Print the data
$counter = 1;
echo '<tbody>';

while($row = mysql_fetch_object($result)) {
	$tgl_awal_arr = explode("-", $row->tgl_awal);
	$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	//$n = $tgl_awal_arr[1];
	$m_awal = $bulan[$tgl_awal_arr[1]];
	$tgl_awal = $tgl_awal_arr[2].' '.$m_awal.' '.$tgl_awal_arr[0];
	
	$tgl_akhir_arr = explode("-", $row->tgl_akhir);
	$bulan = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei', '06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
	//$n = $tgl_awal_arr[1];
	$m_akhir = $bulan[$tgl_akhir_arr[1]];
	$tgl_akhir = $tgl_akhir_arr[2].' '.$m_akhir.' '.$tgl_akhir_arr[0];
	
    echo '
	<tr style="font-weight:bold; color:#3A715E; font-family:arial">
		<td class="edit">
			<a class="ui-icon ui-icon-pencil" onclick="edit('.$row->id.');"></a>
		</td>
		<td class="del">
			<a class="ui-icon ui-icon-trash" onclick="del('.$row->id.');"></a>
		</td>
		<td id="nip_'.$row->id.'" style="width:10%">'.$row->nip.'</td>
		<td id="nama_pengajar_'.$row->id.'" style="width:18%">'.$row->nama_pengajar.'</td>
		<td id="jabatan_'.$row->id.'" style="width:22%">'.$row->jabatan.'</td>
		<td id="tunjangan_'.$row->id.'" style="text-align:right; width:10%">'.number_format($row->tunjangan).'</td>
		<td id="no_sk_'.$row->id.'" style="width:10%">'.$row->no_sk.'</td>
		<td id="tgl_awal_'.$row->id.'" style="width:10%">'.$tgl_awal.'</td>
		<td id="tgl_akhir_'.$row->id.'" style="width:10%">'.$tgl_akhir.'</td>
	</tr>';
	$counter += 1;
}

echo '
	</tbody>
	<tr>
		<td class="footer">
			<a href="#" onclick="dialog_add()" class="tooltip"><span>tambah data</span>
				<font class="ui-icon ui-icon-circle-plus"></font>
			</a>
		</td>
		<td colspan="8" class="footer">&nbsp;</td>
	</tr>
</table>
</div>';
//include('layout-footer.php');
?>
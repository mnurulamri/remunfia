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
	
	$html ='
		<style>
			table {border-collapse:collapse;}
			td {border: solid 1px rgb(215,225,245);}
			.head { background-color:rgb(215,225,245); border: solid 1px rgb(215,225,245); padding:20px; font-weight:bold; font-size:12px; line-height:20px;}
			.nama {border-bottom: solid 1px #fff; border-left: solid 1px rgb(215,225,245); border-right: solid 1px rgb(215,225,245);}
			.row {border-bottom: solid 1px rgb(215,225,245); }
			.pembatas1 {border-top: solid 1px rgb(215,225,245); border-left: solid 1px #fff; border-right: solid 1px #fff; border-bottom: solid 1px #fff; }
			.pembatas2 {border-right: solid 1px #fff; border-left: solid 1px #fff; border-bottom: solid 1px rgb(215,225,245);}
		</style>
	';
	$html.= '
		<table border="1" width="100%">
			<thead>
				<tr class="head">
					<th class="head_jam">Nama Pengajar</th>
					<th class="head_no">Keterangan</th>
					<th class="head_mata_kuliah">Jml</th>
					<th class="head_ruang">Harga Satuan</th>
					<th class="head_mhs">Honor</th>
				</tr>
			</thead><tbody>
	';
	foreach ($data as $pengajar => $records){
		#untuk masing-masing pengajar
		$honor_total = 0;
		$count_pengajar = 0;
		foreach ($records as $baris){
			$honor_total += $baris->honor;
			$html.= '<tr class="row">';
			if($count_pengajar == 0){
				$html.= '<td style="border-top: solid 1px rgb(215,225,245); border-bottom: solid 1px #fff; border-left: solid 1px rgb(215,225,245); ">'.$baris->nama_pengajar.'</td>';
			} else {
				$html.= '<td class="nama">&nbsp;</td>';
			}			
			$html.= "<td>".$baris->jenis_bimbingan."</td>";
			$html.= "<td>".$baris->jml_mhs."</td>";
			$html.= "<td>".$baris->harga_satuan."</td>";
			$html.= "<td>".$baris->honor."</td>";
			$html.= "</tr>";
			$count_pengajar += 1;
		}
		$html.= '<tr><td class="pembatas1">tes</td><td colspan="3" style="border-bottom: solid 1px #fff;"></td><td>'.$honor_total.'</td></tr>';
		$html.= '<tr class=""><td colspan="5" class="pembatas2">xxx</td></tr>';
	}
	
	$html.= "</tbody></table>";
	print $html;
	
} else {
	echo "
		<script language='JavaScript'>
			alert('Tidak Ada Data');
			window.close();
		</script>
	";
}

?>